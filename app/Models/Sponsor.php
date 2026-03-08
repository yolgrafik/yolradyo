<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $fillable = [
        'title',
        'short_description',
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
}
