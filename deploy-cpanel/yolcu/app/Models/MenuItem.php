<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MenuItem extends Model
{
    protected $table = 'menu_items';

    protected $fillable = [
        'location',
        'title',
        'type',
        'url',
        'parent_id',
        'sort_order',
        'target_blank',
        'is_active',
    ];

    protected $casts = [
        'target_blank' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(MenuItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'parent_id')->orderBy('sort_order');
    }

    public function getHrefAttribute(): string
    {
        if ($this->type === 'page' && $this->url) {
            return str_starts_with($this->url, '/') ? url($this->url) : url('/' . $this->url);
        }
        return $this->url ?? '#';
    }

    public static function getForLocation(string $location): \Illuminate\Database\Eloquent\Collection
    {
        return static::where('location', $location)
            ->where('is_active', true)
            ->whereNull('parent_id')
            ->with(['children' => fn ($q) => $q->where('is_active', true)])
            ->orderBy('sort_order')
            ->get();
    }
}
