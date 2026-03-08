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
        'video_type',
        'video_youtube_url',
        'video_path',
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

    public function hasVideo(): bool
    {
        if (($this->video_type ?? '') === 'youtube' && !empty($this->video_youtube_url)) {
            return true;
        }
        if (($this->video_type ?? '') === 'mp4' && !empty($this->video_path)) {
            return true;
        }
        return false;
    }

    public function getYouTubeVideoId(): ?string
    {
        $url = $this->video_youtube_url ?? '';
        if (preg_match('#(?:youtube\.com/watch\?v=|youtu\.be/)([a-zA-Z0-9_-]{11})#', $url, $m)) {
            return $m[1];
        }
        return null;
    }

    public function getYouTubeThumbnailUrl(): ?string
    {
        $id = $this->getYouTubeVideoId();
        return $id ? "https://img.youtube.com/vi/{$id}/hqdefault.jpg" : null;
    }

    public function getVideoPosterUrl(): ?string
    {
        if (($this->video_type ?? '') === 'youtube') {
            return $this->getYouTubeThumbnailUrl();
        }
        if (($this->video_type ?? '') === 'mp4' && !empty($this->image_path)) {
            return asset($this->image_path);
        }
        return null;
    }
}
