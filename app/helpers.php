<?php

if (!function_exists('brand_logo_url')) {
    function brand_logo_url(?string $path = null, string $fallback = 'logo.png'): string
    {
        $path = $path ?? app(\App\Services\SettingsService::class)->get('brand_logo_path');
        return $path ? asset('storage/' . $path) : asset($fallback);
    }
}

if (!function_exists('get_social_links')) {
    function get_social_links(): array
    {
        return app(\App\Services\SettingsService::class)->getSocialLinks();
    }
}
