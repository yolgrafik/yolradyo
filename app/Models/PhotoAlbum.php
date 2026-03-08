<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PhotoAlbum extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image_path',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (self $album) {
            if (empty($album->slug)) {
                $album->slug = Str::slug($album->name . '-' . Str::lower(Str::random(4)));
            }
        });
    }

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class, 'album_id');
    }
}
