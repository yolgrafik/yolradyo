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
        'description',
        'host',
        'dj_id',
        'programci_id',
        'is_active',
        'sort_order',
    ];

    public function dj()
    {
        return $this->belongsTo(DjProfile::class, 'dj_id');
    }

    public function programci()
    {
        return $this->belongsTo(Programci::class, 'programci_id');
    }

    public function getHostNameAttribute(): string
    {
        if ($this->programci_id && $this->programci) {
            return $this->programci->ad;
        }
        if ($this->dj_id && $this->dj) {
            return $this->dj->name;
        }
        return $this->host ?? '—';
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

    public function getEndTimeFormattedAttribute(): string
    {
        if (!$this->end_time) return '';
        $t = is_string($this->end_time) ? $this->end_time : $this->end_time->format('H:i:s');
        return substr($t, 0, 5); // HH:MM
    }
}
