<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArtistVideo extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'cover_image_path',
        'video_type',
        'mp4_path',
        'youtube_url',
        'is_active',
        'is_featured',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $url = (string) ($this->youtube_url ?? '');
        if ($url === '') {
            return null;
        }

        if (preg_match('~(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([A-Za-z0-9_-]{6,})~', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        return null;
    }
}
