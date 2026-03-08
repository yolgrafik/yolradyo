<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class News extends Model
{
    protected static ?string $resolvedTableName = null;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'cover_image',
        'video_url',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (self $news): void {
            if (empty($news->slug) && !empty($news->title)) {
                $news->slug = Str::slug($news->title);
            }
        });
    }

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(static::resolveTableName());
    }

    public static function resolveTableName(): string
    {
        if (static::$resolvedTableName !== null) {
            return static::$resolvedTableName;
        }

        foreach (['news', 'news_posts', 'haberler'] as $table) {
            if (Schema::hasTable($table)) {
                static::$resolvedTableName = $table;
                return $table;
            }
        }

        static::$resolvedTableName = 'news';
        return static::$resolvedTableName;
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function media()
    {
        return $this->hasMany(NewsMedia::class)->orderBy('sort_order')->orderBy('id');
    }

    public function getCoverImageAttribute($value): ?string
    {
        if (!empty($value)) {
            return $value;
        }

        if (!empty($this->attributes['image'])) {
            return $this->attributes['image'];
        }

        return $this->attributes['image_path'] ?? null;
    }

    public function getImageAttribute($value): ?string
    {
        return $this->cover_image;
    }

    public function getYoutubeEmbedUrlAttribute(): ?string
    {
        $url = (string) ($this->video_url ?? '');
        if ($url === '') {
            return null;
        }

        if (preg_match('~(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([A-Za-z0-9_-]{6,})~', $url, $m)) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        return null;
    }
}
