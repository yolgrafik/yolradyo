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

            $approvedRequests = [];
            if (Schema::hasTable('song_requests')) {
                $approvedRequests = \App\Models\SongRequest::where('status', 'approved')
                    ->orderByDesc('approved_at')
                    ->limit(30)
                    ->get(['full_name', 'artist_name', 'song_name']);
            }
            $view->with('approvedSongRequests', $approvedRequests);
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
