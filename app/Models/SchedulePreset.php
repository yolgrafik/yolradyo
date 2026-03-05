<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchedulePreset extends Model
{
    protected $fillable = ['title', 'start_time', 'end_time', 'sort_order'];

    public function getStartFormattedAttribute(): string
    {
        return $this->start_time ? substr($this->start_time, 0, 5) : '';
    }

    public function getEndFormattedAttribute(): string
    {
        return $this->end_time ? substr($this->end_time, 0, 5) : '';
    }
}
