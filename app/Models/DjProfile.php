<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DjProfile extends Model
{
    protected $fillable = [
        'name',
        'bio',
        'initials',
        'avatar_path',
        'is_live',
    ];

    protected $casts = [
        'is_live' => 'boolean',
    ];

    public function scopeLive($query)
    {
        return $query->where('is_live', true);
    }

    public function getDisplayInitialsAttribute(): string
    {
        if ($this->attributes['initials'] ?? null) {
            return strtoupper(substr($this->attributes['initials'], 0, 10));
        }
        $words = preg_split('/\s+/', trim($this->name ?? ''), 2);
        if (count($words) >= 2) {
            return strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        }
        return strtoupper(substr($this->name ?? '?', 0, 2));
    }
}
