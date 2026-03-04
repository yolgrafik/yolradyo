<?php

namespace App\Services;

use App\Models\SiteThemeSetting;
use Illuminate\Support\Facades\Schema;

class ThemeSettingsService
{
    public function get(): array
    {
        if (!Schema::hasTable('site_theme_settings')) {
            return $this->fromLegacySettings();
        }

        $row = SiteThemeSetting::first();
        if (!$row) {
            return $this->fromLegacySettings();
        }

        $data = $row->toArray();
        unset($data['id'], $data['created_at'], $data['updated_at']);

        $merged = array_merge(SiteThemeSetting::defaults(), $data);
        if (empty($merged['header_bg'])) {
            $merged['header_bg'] = 'linear-gradient(180deg, rgba(11,15,26,0.92) 0%, rgba(17,24,39,0.9) 100%)';
        }
        if (empty($merged['footer_bg'])) {
            $merged['footer_bg'] = 'rgba(5,7,12,0.85)';
        }
        return $merged;
    }

    protected function fromLegacySettings(): array
    {
        $defaults = SiteThemeSetting::defaults();
        if (!Schema::hasTable('site_settings')) {
            return $defaults;
        }

        $settings = app(SettingsService::class);
        $legacy = [
            'primary' => $settings->get('theme_primary'),
            'accent' => $settings->get('theme_accent'),
            'glow' => $settings->get('theme_glow'),
            'background' => $settings->get('theme_bg'),
            'text' => $settings->get('theme_text'),
        ];

        foreach ($legacy as $key => $value) {
            if ($value !== null && $value !== '') {
                $defaults[$key] = $value;
            }
        }

        return $defaults;
    }

    public function save(array $data): void
    {
        if (!Schema::hasTable('site_theme_settings')) {
            return;
        }

        $row = SiteThemeSetting::first();
        $fillable = (new SiteThemeSetting)->getFillable();

        $payload = [];
        foreach ($fillable as $key) {
            if (array_key_exists($key, $data)) {
                $payload[$key] = $key === 'radius' ? (int) $data[$key] : (string) $data[$key];
            }
        }

        if ($row) {
            $row->update($payload);
        } else {
            SiteThemeSetting::create(array_merge(SiteThemeSetting::defaults(), $payload));
        }
    }
}
