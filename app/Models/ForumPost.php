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
        'approval_status',
        'video_url',
        'file_path',
        'file_name',
        'file_type',
    ];

    public const TYPE_VIDEO = 'video';
    public const TYPE_MP3 = 'mp3';
    public const TYPE_PHOTO = 'photo';
    public const TYPE_REQUEST = 'request';
    public const TYPE_COMPLAINT = 'complaint';

    public const STATUS_OPEN = 'open';
    public const STATUS_CLOSED = 'closed';

    public const APPROVAL_PENDING = 'pending';
    public const APPROVAL_APPROVED = 'approved';
    public const APPROVAL_REJECTED = 'rejected';

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
            self::TYPE_VIDEO => 'Video Gönder',
            self::TYPE_MP3 => 'MP3 Gönder',
            self::TYPE_PHOTO => 'Foto Gönder',
            self::TYPE_REQUEST => 'İstek',
            self::TYPE_COMPLAINT => 'Şikayet',
            default => $this->type,
        };
    }

    public function getMediaUrlAttribute(): ?string
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    public function getVideoThumbnailUrlAttribute(): ?string
    {
        if (!$this->video_url) {
            return null;
        }
        if (preg_match('#(?:youtube\.com/watch\?v=|youtu\.be/|youtube\.com/embed/)([a-zA-Z0-9_-]{11})#', $this->video_url, $m)) {
            return 'https://img.youtube.com/vi/' . $m[1] . '/mqdefault.jpg';
        }
        return null;
    }

    public function isApproved(): bool
    {
        return $this->approval_status === self::APPROVAL_APPROVED;
    }

    public function isPending(): bool
    {
        return $this->approval_status === self::APPROVAL_PENDING;
    }

    public function hasMedia(): bool
    {
        return !empty($this->video_url) || !empty($this->file_path);
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
