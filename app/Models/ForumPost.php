<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class ForumPost extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'slug',
        'body',
        'status',
    ];

    public const TYPE_REQUEST = 'request';
    public const TYPE_COMPLAINT = 'complaint';

    public const STATUS_OPEN = 'open';
    public const STATUS_CLOSED = 'closed';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ForumComment::class, 'post_id');
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_REQUEST => 'İstek',
            self::TYPE_COMPLAINT => 'Şikayet',
            default => $this->type,
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_OPEN => 'Açık',
            self::STATUS_CLOSED => 'Kapalı',
            default => $this->status,
        };
    }

    public static function makeSlug(string $title): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 0;
        while (static::where('slug', $slug)->exists()) {
            $slug = $base . '-' . (++$i);
        }
        return $slug;
    }
}
