<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'day_of_week',
        'start_time',
        'end_time',
        'title',
        'host',
        'dj_id',
        'is_active',
        'sort_order',
    ];

    public function dj()
    {
        return $this->belongsTo(DjProfile::class, 'dj_id');
    }

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeForDay($query, int $day)
    {
        return $query->where('day_of_week', $day);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('start_time');
    }

    public function getStartTimeFormattedAttribute(): string
    {
        if (!$this->start_time) return '';
        $t = is_string($this->start_time) ? $this->start_time : $this->start_time->format('H:i:s');
        return substr($t, 0, 5); // HH:MM
    }
}
