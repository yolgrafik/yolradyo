<?php

namespace App\Providers;

use App\Models\MenuItem;
use App\Models\Setting;
use App\Services\SettingsService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
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
        $this->app->singleton(\App\Services\MailConfigService::class, function ($app) {
            return new \App\Services\MailConfigService($app->make(SettingsService::class));
        });
        $this->app->singleton(\App\Services\ThemeService::class, fn () => new \App\Services\ThemeService());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('contact-messages', function ($request) {
            return Limit::perHour(5)
                ->by($request->user()->id)
                ->response(fn () => redirect()->back()->with('error', 'Çok fazla mesaj gönderdiniz. Lütfen 1 saat sonra tekrar deneyin.'));
        });

        View::composer(['layouts.frontend', 'frontend.home', 'frontend.programlar', 'partials.requests-ticker'], function ($view) {
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
                $themeSettings = app(\App\Services\ThemeService::class)->getSettings();
            } catch (\Throwable $e) {
                $themeSettings = ['vars' => [], 'bg_mode' => 'color', 'bg_color' => '#0b0f16'];
            }
            $view->with('themeSettings', $themeSettings);

            $headerMenu = [];
            $footerMenu = [];
            if (Schema::hasTable('menu_items')) {
                try {
                    $headerMenu = MenuItem::getForLocation('header');
                    $footerMenu = MenuItem::getForLocation('footer');
                } catch (\Throwable $e) {
                    // ignore
                }
            }
            $view->with('headerMenu', $headerMenu);
            $view->with('footerMenu', $footerMenu);
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
