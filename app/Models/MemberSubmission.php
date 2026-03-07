<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MemberSubmission extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'description',
        'video_url',
        'file_path',
        'file_name',
        'status',
    ];

    public const TYPES = [
        'istek' => 'İstek',
        'sikayet' => 'Şikayet',
        'image' => 'Fotoğraf',
        'video' => 'Video',
        'mp3' => 'MP3 Gönder',
    ];

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
        if (preg_match('#tiktok\.com.*/video/(\d+)#', $this->video_url, $m)) {
            return null;
        }
        return null;
    }

    public const STATUSES = [
        'pending' => 'Beklemede',
        'approved' => 'Onaylı',
        'rejected' => 'Reddedildi',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? $this->type;
    }

    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
