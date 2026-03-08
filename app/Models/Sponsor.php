<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sponsor extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'image_path',
        'website_url',
        'facebook_url',
        'instagram_url',
        'x_url',
        'youtube_url',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected static function booted(): void
    {
        static::saving(function (Sponsor $sponsor) {
            if (empty($sponsor->slug) && !empty($sponsor->title)) {
                $sponsor->slug = Str::slug($sponsor->title) . '-' . Str::random(4);
            }
        });
    }
}
