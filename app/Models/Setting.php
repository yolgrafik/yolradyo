<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';

    protected $fillable = [
        'radio_stream_url',
        'radio_backup_stream_url',
    ];

    protected $casts = [
        'radio_stream_url' => 'string',
        'radio_backup_stream_url' => 'string',
    ];

    /**
     * Get the first (and typically only) settings row.
     */
    public static function getSettings(): ?self
    {
        return static::first();
    }
}
