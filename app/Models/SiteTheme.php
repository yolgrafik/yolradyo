<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteTheme extends Model
{
    protected $table = 'site_theme';

    protected $fillable = [
        'theme_id',
        'bg_mode',
        'bg_color',
        'bg_image',
        'overlay_color',
        'overlay_opacity',
        'bg_blur',
        'button_color',
        'button_hover_color',
        'schedule_color',
        'schedule_active_color',
        'apply_all',
    ];

    protected $casts = [
        'theme_id' => 'integer',
        'apply_all' => 'boolean',
        'overlay_opacity' => 'integer',
        'bg_blur' => 'integer',
    ];

    public static function getSettings(): ?self
    {
        return self::first();
    }
}
