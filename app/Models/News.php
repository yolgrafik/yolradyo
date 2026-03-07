<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class News extends Model
{
    protected static ?string $resolvedTableName = null;

    protected $fillable = [
        'title',
        'excerpt',
        'content',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable(static::resolveTableName());
    }

    public static function resolveTableName(): string
    {
        if (static::$resolvedTableName !== null) {
            return static::$resolvedTableName;
        }

        foreach (['news', 'news_posts', 'haberler'] as $table) {
            if (Schema::hasTable($table)) {
                static::$resolvedTableName = $table;
                return $table;
            }
        }

        static::$resolvedTableName = 'news';
        return static::$resolvedTableName;
    }

    public function getImageAttribute($value): ?string
    {
        if (!empty($value)) {
            return $value;
        }

        return $this->attributes['image_path'] ?? null;
    }
}
