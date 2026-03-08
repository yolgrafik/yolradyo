<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Programci extends Model
{
    use SoftDeletes;

    protected $table = 'programcilar';

    protected $fillable = [
        'ad',
        'slug',
        'avatar_path',
        'kisa_aciklama',
        'uzun_aciklama',
        'email',
        'instagram',
        'facebook',
        'tiktok',
        'youtube',
        'website',
        'aktif',
        'sira',
        'seo_title',
        'seo_description',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'programci_id');
    }

    public function getAvatarUrlAttribute(): ?string
    {
        if (!$this->avatar_path) {
            return null;
        }
        return Storage::url($this->avatar_path);
    }

    public function getDisplayInitialsAttribute(): string
    {
        $words = preg_split('/\s+/', trim($this->ad ?? ''), 2);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->ad ?? '?', 0, 2));
    }

    public function scopeActive($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sira')->orderBy('ad');
    }

    public static function uniqueSlug(string $base, ?int $excludeId = null): string
    {
        $slug = $base;
        $i = 1;
        $query = static::withTrashed()->where('slug', $slug);
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        while ($query->exists()) {
            $slug = $base . '-' . $i;
            $i++;
            $query = static::withTrashed()->where('slug', $slug);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }
        return $slug;
    }

}
