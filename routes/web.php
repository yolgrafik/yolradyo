<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;

Route::get('/', [FrontendController::class, 'home']);
Route::get('/programlar', [FrontendController::class, 'programlar']);
Route::get('/haberler', [FrontendController::class, 'haberler']);
Route::get('/videolar', [FrontendController::class, 'videolar']);
Route::get('/galeri', [FrontendController::class, 'galeri']);
Route::get('/reklam', [FrontendController::class, 'reklam']);
Route::get('/hakkimizda', fn () => redirect('/hakkimizda/biz-kimiz'));
Route::get('/hakkimizda/{slug}', [FrontendController::class, 'hakkimizda'])->where('slug', 'biz-kimiz|misyon|politika');
Route::get('/iletisim', [FrontendController::class, 'iletisim']);
Route::get('/gizlilik', [FrontendController::class, 'gizlilik']);
Route::get('/cerez', [FrontendController::class, 'cerez']);
Route::get('/kullanim', [FrontendController::class, 'kullanim']);
Route::get('/kvkk', [FrontendController::class, 'kvkk']);

Route::get('/api/radio/status', App\Http\Controllers\Api\RadioStatusController::class);
Route::get('/api/requests/approved', App\Http\Controllers\Api\ApprovedRequestsController::class);
Route::get('/api/schedule', App\Http\Controllers\Api\ScheduleController::class)->name('api.schedule');

Route::post('/istek-gonder', [App\Http\Controllers\RequestController::class, 'store'])->name('song.request');

Route::prefix('admin')->group(function () {
    Route::get('', function () {
        return session('admin_logged_in') ? redirect('/admin/dashboard') : redirect('/admin/login');
    });

    Route::get('login', [App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::get('logout', function () {
        if (session('admin_id') && \Illuminate\Support\Facades\Schema::hasTable('admin_activity_logs')) {
            \App\Helpers\ActivityLogger::log('admin.logout', null, (int) session('admin_id'));
        }
        session()->forget(['admin_logged_in', 'admin_id']);
        return redirect('/admin/login');
    })->name('admin.logout');

    Route::middleware('admin')->group(function () {
        Route::get('dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::get('shoutcast/player', [App\Http\Controllers\Admin\ShoutcastPlayerController::class, 'index'])->name('admin.shoutcast.player.index');
    Route::post('shoutcast/player', [App\Http\Controllers\Admin\ShoutcastPlayerController::class, 'store'])->name('admin.shoutcast.player.store');
    Route::redirect('stream-settings', '/admin/shoutcast/player', 301);

    Route::get('settings/general', [App\Http\Controllers\Admin\SettingsController::class, 'generalForm'])->name('admin.settings.general');
    Route::post('settings/general', [App\Http\Controllers\Admin\SettingsController::class, 'saveGeneral']);
    Route::get('settings/branding', [App\Http\Controllers\Admin\SettingsController::class, 'brandingForm'])->name('admin.settings.branding');
    Route::post('settings/branding', [App\Http\Controllers\Admin\SettingsController::class, 'saveBranding']);
    Route::get('settings/seo', [App\Http\Controllers\Admin\SettingsController::class, 'seoForm'])->name('admin.settings.seo');
    Route::post('settings/seo', [App\Http\Controllers\Admin\SettingsController::class, 'saveSeo']);
    Route::get('settings/social', [App\Http\Controllers\Admin\SettingsController::class, 'socialForm'])->name('admin.settings.social');
    Route::post('settings/social', [App\Http\Controllers\Admin\SettingsController::class, 'saveSocial']);
    Route::get('settings/footer', [App\Http\Controllers\Admin\SettingsController::class, 'footerForm'])->name('admin.settings.footer');
    Route::post('settings/footer', [App\Http\Controllers\Admin\SettingsController::class, 'saveFooter']);
    Route::get('settings/theme', [App\Http\Controllers\Admin\SettingsController::class, 'themeForm'])->name('admin.settings.theme');
    Route::post('settings/theme', [App\Http\Controllers\Admin\SettingsController::class, 'saveTheme']);

        Route::middleware('admin.permission:users.manage')->prefix('users')->name('admin.users.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])->name('index');
            Route::get('create', [App\Http\Controllers\Admin\AdminUserController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\AdminUserController::class, 'store'])->name('store');
            Route::get('{user}/edit', [App\Http\Controllers\Admin\AdminUserController::class, 'edit'])->name('edit');
            Route::put('{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'update'])->name('update');
            Route::delete('{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])->name('destroy');
            Route::post('{user}/toggle', [App\Http\Controllers\Admin\AdminUserController::class, 'toggle'])->name('toggle');
            Route::post('{user}/avatar-remove', [App\Http\Controllers\Admin\AdminUserController::class, 'removeAvatar'])->name('avatar-remove');
        });

        Route::middleware('admin.permission:users.manage')->prefix('roles')->name('admin.roles.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('index');
            Route::get('create', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('store');
            Route::get('{role}/edit', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('edit');
            Route::put('{role}', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('update');
            Route::delete('{role}', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('destroy');
        });

        Route::middleware('admin.permission:logs.view')->get('activity-logs', [App\Http\Controllers\Admin\ActivityLogController::class, 'index'])->name('admin.activity-logs.index');

        Route::prefix('security')->name('admin.security.')->group(function () {
            Route::get('2fa', [App\Http\Controllers\Admin\TwoFactorController::class, 'index'])->name('2fa');
            Route::post('2fa/enable', [App\Http\Controllers\Admin\TwoFactorController::class, 'enable'])->name('2fa.enable');
            Route::post('2fa/confirm', [App\Http\Controllers\Admin\TwoFactorController::class, 'confirmEnable'])->name('2fa.confirm');
            Route::post('2fa/disable', [App\Http\Controllers\Admin\TwoFactorController::class, 'disable'])->name('2fa.disable');
        });

        Route::get('notifications/pending-count', [App\Http\Controllers\Admin\NotificationController::class, 'pendingCount'])->name('admin.notifications.pending-count');
        Route::get('messages', [App\Http\Controllers\Admin\MessagesController::class, 'index'])->name('admin.messages.index');
        Route::post('messages/bulk-destroy', [App\Http\Controllers\Admin\MessagesController::class, 'bulkDestroy'])->name('admin.messages.bulk-destroy');
        Route::post('messages/{songRequest}/approve', [App\Http\Controllers\Admin\MessagesController::class, 'approve'])->name('admin.messages.approve');
        Route::post('messages/{songRequest}/blacklist', [App\Http\Controllers\Admin\MessagesController::class, 'blacklist'])->name('admin.messages.blacklist');
        Route::get('moderation', [App\Http\Controllers\Admin\ModerationController::class, 'index'])->name('admin.moderation.index');
        Route::get('blacklist', [App\Http\Controllers\Admin\BlacklistController::class, 'index'])->name('admin.blacklist.index');
        Route::delete('blacklist/{blacklist}', [App\Http\Controllers\Admin\BlacklistController::class, 'destroy'])->name('admin.blacklist.destroy');

        Route::prefix('song-requests')->name('admin.song-requests.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\SongRequestAdminController::class, 'index'])->name('index');
            Route::post('{songRequest}/approve', [App\Http\Controllers\Admin\SongRequestAdminController::class, 'approve'])->name('approve');
            Route::post('{songRequest}/reject', [App\Http\Controllers\Admin\SongRequestAdminController::class, 'reject'])->name('reject');
            Route::post('{songRequest}/blacklist', [App\Http\Controllers\Admin\SongRequestAdminController::class, 'blacklist'])->name('blacklist');
            Route::delete('{songRequest}', [App\Http\Controllers\Admin\SongRequestAdminController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('djs')->name('admin.djs.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\DjProfileController::class, 'index'])->name('index');
            Route::get('create', [App\Http\Controllers\Admin\DjProfileController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\DjProfileController::class, 'store'])->name('store');
            Route::get('{dj}/edit', [App\Http\Controllers\Admin\DjProfileController::class, 'edit'])->name('edit');
            Route::put('{dj}', [App\Http\Controllers\Admin\DjProfileController::class, 'update'])->name('update');
            Route::delete('{dj}', [App\Http\Controllers\Admin\DjProfileController::class, 'destroy'])->name('destroy');
            Route::post('{dj}/set-live', [App\Http\Controllers\Admin\DjProfileController::class, 'setLive'])->name('set-live');
            Route::post('{dj}/set-offline', [App\Http\Controllers\Admin\DjProfileController::class, 'setOffline'])->name('set-offline');
        });

        Route::prefix('schedule')->name('admin.schedule.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\ScheduleController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\Admin\ScheduleController::class, 'store'])->name('store');
            Route::post('copy/{fromDay}', [App\Http\Controllers\Admin\ScheduleController::class, 'copy'])->name('copy');
            Route::put('{schedule}', [App\Http\Controllers\Admin\ScheduleController::class, 'update'])->name('update');
            Route::delete('{schedule}', [App\Http\Controllers\Admin\ScheduleController::class, 'destroy'])->name('destroy');
            Route::post('{schedule}/toggle', [App\Http\Controllers\Admin\ScheduleController::class, 'toggle'])->name('toggle');
        });

        Route::prefix('sliders')->name('admin.sliders.')->group(function () {
            Route::get('/', [App\Http\Controllers\Admin\SliderController::class, 'index'])->name('index');
            Route::get('create', [App\Http\Controllers\Admin\SliderController::class, 'create'])->name('create');
            Route::post('/', [App\Http\Controllers\Admin\SliderController::class, 'store'])->name('store');
            Route::post('reorder', [App\Http\Controllers\Admin\SliderController::class, 'reorder'])->name('reorder');
            Route::get('{slider}/edit', [App\Http\Controllers\Admin\SliderController::class, 'edit'])->name('edit');
            Route::put('{slider}', [App\Http\Controllers\Admin\SliderController::class, 'update'])->name('update');
            Route::delete('{slider}', [App\Http\Controllers\Admin\SliderController::class, 'destroy'])->name('destroy');
        });
    });
});
