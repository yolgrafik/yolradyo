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
        'video' => 'Video Link',
        'mp3' => 'MP3 Gönder',
    ];

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
