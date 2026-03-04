<?php

if (!function_exists('setting')) {
    function setting(string $key, mixed $default = null): mixed
    {
        return app(\App\Services\SettingsService::class)->get($key, $default);
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
        return app(\App\Services\ThemeSettingsService::class)->get();
    }
}
