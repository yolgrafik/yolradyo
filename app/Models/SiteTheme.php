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
    ];

    protected $casts = [
        'theme_id' => 'integer',
        'overlay_opacity' => 'integer',
        'bg_blur' => 'integer',
    ];

    public static function getSettings(): ?self
    {
        return self::first();
    }
}
