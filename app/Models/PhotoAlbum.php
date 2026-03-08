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
                $album->slug = Str::slug($album->name . '-' . Str::random(4));
            }
        });
    }

    public function photos()
    {
        return $this->hasMany(GalleryPhoto::class, 'album_id');
    }
}
