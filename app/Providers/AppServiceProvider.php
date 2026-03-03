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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.frontend', function ($view) {
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
        });
    }
}
