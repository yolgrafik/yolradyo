<?php

if (!function_exists('brand_logo_url')) {
    function brand_logo_url(?string $path = null): string
    {
        $path = $path ?? app(\App\Services\SettingsService::class)->get('brand_logo_path');
        return $path ? asset('storage/' . $path) : asset('logo.png');
    }
}

if (!function_exists('get_social_links')) {
    function get_social_links(): array
    {
        return app(\App\Services\SettingsService::class)->getSocialLinks();
    }
}

if (!function_exists('get_theme_settings')) {
    function get_theme_settings(): array
    {
        return app(\App\Services\ThemeService::class)->getSettings();
    }
}
