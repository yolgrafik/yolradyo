<?php

namespace App\Services;

use App\Models\SiteTheme;
use Illuminate\Support\Facades\Schema;

class ThemeService
{
    protected array $presets;

    public function __construct()
    {
        $this->presets = config('theme_presets', []);
    }

    public function getPresets(): array
    {
        return $this->presets;
    }

    public function getPreset(int $id): ?array
    {
        return $this->presets[$id] ?? null;
    }

    public function getSettings(): array
    {
        if (!Schema::hasTable('site_theme')) {
            return $this->defaults();
        }

        $row = SiteTheme::getSettings();
        if (!$row) {
            return $this->defaults();
        }

        $preset = $this->getPreset((int) $row->theme_id) ?? $this->getPreset(1);
        $vars = $this->deriveVars($preset);

        return [
            'theme_id' => (int) $row->theme_id,
            'bg_mode' => $row->bg_mode ?? 'color',
            'bg_color' => $row->bg_color ?? '#0b0f16',
            'bg_image' => $row->bg_image,
            'overlay_color' => $row->overlay_color ?? '#000000',
            'overlay_opacity' => (int) ($row->overlay_opacity ?? 55),
            'bg_blur' => (int) ($row->bg_blur ?? 0),
            'vars' => $vars,
        ];
    }

    protected function deriveVars(array $preset): array
    {
        $primary = $preset['primary'] ?? '#ff0033';
        $primaryHover = $preset['primary_hover'] ?? '#ff3355';
        $accent = $preset['accent'] ?? $primary;
        $glow = $preset['glow'] ?? $primary;

        return [
            'primary' => $primary,
            'primary_hover' => $primaryHover,
            'accent' => $accent,
            'glow' => $glow,
            'header_bg' => 'linear-gradient(180deg, rgba(11,15,26,0.92) 0%, rgba(17,24,39,0.9) 100%)',
            'footer_bg' => 'rgba(5,7,12,0.92)',
            'link' => $this->lighten($accent, 0.3),
            'link_hover' => $this->lighten($accent, 0.5),
            'badge' => $accent,
        ];
    }

    protected function lighten(string $hex, float $amount): string
    {
        if (!preg_match('/^#([0-9A-Fa-f]{6})$/', $hex, $m)) {
            return '#60a5fa';
        }
        $r = min(255, hexdec(substr($m[1], 0, 2)) + (int)(255 * $amount));
        $g = min(255, hexdec(substr($m[1], 2, 2)) + (int)(255 * $amount));
        $b = min(255, hexdec(substr($m[1], 4, 2)) + (int)(255 * $amount));
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }

    protected function defaults(): array
    {
        $preset = $this->getPreset(1) ?? ['primary' => '#ff0033', 'primary_hover' => '#ff3355', 'accent' => '#ff0033', 'glow' => '#ff0033'];
        return [
            'theme_id' => 1,
            'bg_mode' => 'color',
            'bg_color' => '#0b0f16',
            'bg_image' => null,
            'overlay_color' => '#000000',
            'overlay_opacity' => 55,
            'bg_blur' => 0,
            'vars' => $this->deriveVars($preset),
        ];
    }

    public function save(array $data): void
    {
        if (!Schema::hasTable('site_theme')) {
            return;
        }

        $row = SiteTheme::first();
        $payload = [
            'theme_id' => (int) ($data['theme_id'] ?? 1),
            'bg_mode' => in_array($data['bg_mode'] ?? '', ['color', 'image']) ? $data['bg_mode'] : 'color',
            'bg_color' => $data['bg_color'] ?? '#0b0f16',
            'overlay_color' => $data['overlay_color'] ?? '#000000',
            'overlay_opacity' => min(80, max(0, (int) ($data['overlay_opacity'] ?? 55))),
            'bg_blur' => min(12, max(0, (int) ($data['bg_blur'] ?? 0))),
        ];

        if (isset($data['bg_image'])) {
            $payload['bg_image'] = $data['bg_image'] ?: null;
        }

        if ($row) {
            $row->update($payload);
        } else {
            SiteTheme::create($payload);
        }
    }
}
