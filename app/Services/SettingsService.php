<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SettingsService
{
    protected string $table = 'site_settings';
    protected int $cacheTtl = 10;

    public function get(string $key, mixed $default = null): mixed
    {
        $cacheKey = 'site_settings_' . $key;

        return Cache::remember($cacheKey, $this->cacheTtl, function () use ($key, $default) {
            $row = DB::table($this->table)->where('key', $key)->first();
            if (!$row) {
                return $default;
            }
            return $this->castValue($row->value, $row->type ?? 'text');
        });
    }

    public function set(string $key, mixed $value, string $type = 'text'): void
    {
        $serialized = $this->serializeValue($value, $type);
        $exists = DB::table($this->table)->where('key', $key)->exists();

        if ($exists) {
            DB::table($this->table)->where('key', $key)->update([
                'value' => $serialized,
                'type' => $type,
                'updated_at' => now(),
            ]);
        } else {
            DB::table($this->table)->insert([
                'key' => $key,
                'value' => $serialized,
                'type' => $type,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Cache::forget('site_settings_' . $key);
        Cache::forget('site_settings_all');
    }

    public function setMany(array $items): void
    {
        foreach ($items as $key => $value) {
            $type = 'text';
            if (is_array($value) && isset($value['value'], $value['type'])) {
                $type = $value['type'];
                $value = $value['value'];
            }
            $this->set($key, $value, $type);
        }
    }

    public function getAll(): array
    {
        return Cache::remember('site_settings_all', $this->cacheTtl, function () {
            $rows = DB::table($this->table)->get();
            $out = [];
            foreach ($rows as $row) {
                $out[$row->key] = $this->castValue($row->value, $row->type ?? 'text');
            }
            return $out;
        });
    }

    public function forget(string $key): void
    {
        DB::table($this->table)->where('key', $key)->delete();
        Cache::forget('site_settings_' . $key);
        Cache::forget('site_settings_all');
    }

    public function clearCache(): void
    {
        $keys = DB::table($this->table)->pluck('key');
        foreach ($keys as $key) {
            Cache::forget('site_settings_' . $key);
        }
        Cache::forget('site_settings_all');
    }

    protected function castValue(?string $value, string $type): mixed
    {
        if ($value === null) {
            return null;
        }
        return match ($type) {
            'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
            'json' => json_decode($value, true),
            'integer' => (int) $value,
            'float' => (float) $value,
            default => $value,
        };
    }

    protected function serializeValue(mixed $value, string $type): ?string
    {
        if ($value === null) {
            return null;
        }
        return match ($type) {
            'boolean' => $value ? '1' : '0',
            'json' => is_string($value) ? $value : json_encode($value),
            default => (string) $value,
        };
    }
}
