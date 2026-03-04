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
            'button_color' => $row->button_color ?? '#c92a2a',
            'button_hover_color' => $row->button_hover_color ?? '#dc2626',
            'schedule_color' => $row->schedule_color ?? '#1e2430',
            'schedule_active_color' => $row->schedule_active_color ?? '#c92a2a',
            'apply_all' => (bool) ($row->apply_all ?? false),
            'vars' => $vars,
        ];
    }

    protected function deriveVars(array $preset): array
    {
        $accent = $preset['accent'] ?? $preset['primary'] ?? '#c92a2a';

        $headerBg = $preset['header_bg'] ?? $this->themeHeaderBg($accent);
        $footerBg = $preset['footer_bg'] ?? $this->themeFooterBg($accent);
        $barBg = $preset['bar_bg'] ?? $this->themeSolidBg($accent);

        $themeHover = $this->lighten($accent, 0.1);
        $themeDark = $this->darken($accent, 0.2);
        $themeGradient = "linear-gradient(180deg, {$themeDark}, {$accent})";

        return [
            'theme' => $accent,
            'theme_hover' => $themeHover,
            'theme_dark' => $themeDark,
            'header_bg' => $headerBg,
            'footer_bg' => $footerBg,
            'bar_bg' => $barBg,
            'theme_gradient' => $themeGradient,
        ];
    }

    protected function themeHeaderBg(string $accent): string
    {
        return $this->themeSolidBg($accent);
    }

    protected function themeFooterBg(string $accent): string
    {
        return $this->themeSolidBg($accent);
    }

    /** Header ve footer aynı düz renk, gradient yok */
    protected function themeSolidBg(string $accent): string
    {
        return $this->hexToRgba($this->darken($accent, 0.45), 0.97);
    }

    protected function hexToRgba(string $hex, float $alpha): string
    {
        if (!preg_match('/^#([0-9A-Fa-f]{6})$/', $hex, $m)) {
            return "rgba(11,15,26,{$alpha})";
        }
        $r = hexdec(substr($m[1], 0, 2));
        $g = hexdec(substr($m[1], 2, 2));
        $b = hexdec(substr($m[1], 4, 2));
        return sprintf("rgba(%d,%d,%d,%.2f)", $r, $g, $b, $alpha);
    }

    protected function lighten(string $hex, float $amount): string
    {
        if (!preg_match('/^#([0-9A-Fa-f]{6})$/', $hex, $m)) {
            return '#ffffff';
        }
        $r = min(255, hexdec(substr($m[1], 0, 2)) + (int)(255 * $amount));
        $g = min(255, hexdec(substr($m[1], 2, 2)) + (int)(255 * $amount));
        $b = min(255, hexdec(substr($m[1], 4, 2)) + (int)(255 * $amount));
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }

    protected function darken(string $hex, float $amount): string
    {
        if (!preg_match('/^#([0-9A-Fa-f]{6})$/', $hex, $m)) {
            return '#0a0a0a';
        }
        $r = max(0, hexdec(substr($m[1], 0, 2)) - (int)(255 * $amount));
        $g = max(0, hexdec(substr($m[1], 2, 2)) - (int)(255 * $amount));
        $b = max(0, hexdec(substr($m[1], 4, 2)) - (int)(255 * $amount));
        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }

    protected function defaults(): array
    {
        $preset = $this->getPreset(1) ?? ['primary' => '#c92a2a', 'primary_hover' => '#dc2626', 'accent' => '#c92a2a'];
        return [
            'theme_id' => 1,
            'bg_mode' => 'color',
            'bg_color' => '#0b0f16',
            'bg_image' => null,
            'overlay_color' => '#000000',
            'overlay_opacity' => 55,
            'bg_blur' => 0,
            'button_color' => '#c92a2a',
            'button_hover_color' => '#dc2626',
            'schedule_color' => '#1e2430',
            'schedule_active_color' => '#c92a2a',
            'apply_all' => false,
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
            'button_color' => $data['button_color'] ?? '#c92a2a',
            'button_hover_color' => $data['button_hover_color'] ?? '#dc2626',
            'schedule_color' => $data['schedule_color'] ?? '#1e2430',
            'schedule_active_color' => $data['schedule_active_color'] ?? '#c92a2a',
            'apply_all' => (bool) ($data['apply_all'] ?? false),
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
