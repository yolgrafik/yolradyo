<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteThemeSetting extends Model
{
    protected $table = 'site_theme_settings';

    protected $fillable = [
        'primary', 'primary_hover', 'secondary', 'secondary_hover',
        'accent', 'glow', 'background', 'surface', 'surface_2', 'border',
        'text', 'text_muted', 'link', 'link_hover',
        'header_bg', 'header_text', 'header_active',
        'footer_bg', 'footer_text', 'footer_link', 'footer_link_hover',
        'input_bg', 'input_text', 'focus_ring', 'radius',
    ];

    protected $casts = [
        'radius' => 'integer',
    ];

    protected static ?self $instance = null;

    public static function get(): self
    {
        if (self::$instance !== null) {
            return self::$instance;
        }
        $row = self::first();
        if ($row) {
            self::$instance = $row;
            return $row;
        }
        self::$instance = new self(self::defaults());
        return self::$instance;
    }

    public static function defaults(): array
    {
        return [
            'primary' => '#ff0033',
            'primary_hover' => '#ff3355',
            'secondary' => '#374151',
            'secondary_hover' => '#4b5563',
            'accent' => '#c92a2a',
            'glow' => '#c92a2a',
            'background' => '#0b0f16',
            'surface' => '#111827',
            'surface_2' => '#0f172a',
            'border' => 'rgba(255,255,255,0.12)',
            'text' => '#ffffff',
            'text_muted' => '#a9b1c3',
            'link' => '#60a5fa',
            'link_hover' => '#93c5fd',
            'header_bg' => null,
            'header_text' => '#ffffff',
            'header_active' => '#c92a2a',
            'footer_bg' => null,
            'footer_text' => 'rgba(255,255,255,0.65)',
            'footer_link' => 'rgba(255,255,255,0.65)',
            'footer_link_hover' => '#ffffff',
            'input_bg' => 'rgba(255,255,255,0.06)',
            'input_text' => '#f0f2f5',
            'focus_ring' => '#c92a2a',
            'radius' => 14,
        ];
    }

    public function toCssVars(): array
    {
        $row = $this->toArray();
        $vars = [];
        foreach ($row as $key => $value) {
            if (in_array($key, ['id', 'created_at', 'updated_at'], true)) {
                continue;
            }
            $cssKey = '--ry-' . str_replace('_', '-', $key);
            $vars[$cssKey] = $key === 'radius' ? ($value . 'px') : $value;
        }
        return $vars;
    }
}
