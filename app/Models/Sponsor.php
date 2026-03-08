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
        'images',
        'website_url',
        'facebook_url',
        'instagram_url',
        'x_url',
        'youtube_url',
        'video_type',
        'video_youtube_url',
        'video_path',
        'video_poster_path',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'images' => 'array',
    ];

    /**
     * İlk (ana) resmin path'ini döner. Eski sistemde image_path, yeni sistemde images[0].
     */
    public function getFirstImagePath(): ?string
    {
        $imgs = $this->images;
        if (is_array($imgs) && !empty($imgs)) {
            return $imgs[0];
        }
        return $this->image_path;
    }

    /**
     * Galeri için tüm resimler (ilk resim dahil). Boşsa image_path varsa tek elemanlı dizi.
     */
    public function getGalleryImages(): array
    {
        $imgs = $this->images;
        if (is_array($imgs) && !empty($imgs)) {
            return $imgs;
        }
        if ($this->image_path) {
            return [$this->image_path];
        }
        return [];
    }

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

    /**
     * Video önizleme/kapak resmi URL. YouTube: otomatik thumbnail. MP4: video_poster_path > ana görsel > null (placeholder).
     */
    public function getVideoPosterUrl(): ?string
    {
        if (($this->video_type ?? '') === 'youtube') {
            return $this->getYouTubeThumbnailUrl();
        }
        if (($this->video_type ?? '') === 'mp4') {
            if (!empty($this->video_poster_path)) {
                return asset($this->video_poster_path);
            }
            $first = $this->getFirstImagePath();
            if ($first) {
                return asset($first);
            }
        }
        return null;
    }
}
