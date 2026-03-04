<?php

namespace App\Providers;

use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SettingsService::class, fn () => new SettingsService());
        $this->app->singleton(\App\Services\ThemeSettingsService::class, fn () => new \App\Services\ThemeSettingsService());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['layouts.frontend', 'partials.requests-ticker'], function ($view) {
            $settings = null;
            if (Schema::hasTable('settings')) {
                $settings = Setting::getSettings();
            }
            $view->with('radioSettings', $settings);

            $siteSettings = [];
            if (Schema::hasTable('site_settings')) {
                $siteSettings = app(SettingsService::class)->getAll();
            }
            $view->with('siteSettings', $siteSettings);

            $socialLinks = [];
            if (Schema::hasTable('site_settings')) {
                try {
                    $socialLinks = app(SettingsService::class)->getSocialLinks();
                } catch (\Throwable $e) {
                    $socialLinks = [];
                }
            }
            $view->with('socialLinks', $socialLinks);

            $themeSettings = [];
            try {
                if (Schema::hasTable('site_theme_settings') || Schema::hasTable('site_settings')) {
                    $themeSettings = app(\App\Services\ThemeSettingsService::class)->get();
                } else {
                    $themeSettings = \App\Models\SiteThemeSetting::defaults();
                }
            } catch (\Throwable $e) {
                $themeSettings = \App\Models\SiteThemeSetting::defaults();
            }
            $view->with('themeSettings', $themeSettings);
        });

        View::composer('admin.layouts.app', function ($view) {
            $currentAdmin = null;
            if (session('admin_id') && Schema::hasTable('admins')) {
                $currentAdmin = \App\Models\Admin::with('role')->find(session('admin_id'));
            }
            $view->with('currentAdmin', $currentAdmin);
        });
    }
}
