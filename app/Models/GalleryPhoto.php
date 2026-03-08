<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GalleryPhoto extends Model
{
    protected $fillable = [
        'album_id',
        'title',
        'short_description',
        'image_path',
        'is_cover',
        'is_announcement',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_cover' => 'boolean',
        'is_announcement' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function album()
    {
        return $this->belongsTo(PhotoAlbum::class, 'album_id');
    }
}
