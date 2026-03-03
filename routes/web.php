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

Route::prefix('admin')->group(function () {
    Route::get('', function () {
        return session('admin_logged_in') ? redirect('/admin/dashboard') : redirect('/admin/login');
    });

    Route::get('login', [App\Http\Controllers\Admin\AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    Route::get('logout', function () {
        session()->forget('admin_logged_in');
        return redirect('/admin/login');
    })->name('admin.logout');

    Route::get('dashboard', function () {
        if (!session('admin_logged_in')) {
            return redirect('/admin/login');
        }
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('stream-settings', [App\Http\Controllers\Admin\StreamSettingsController::class, 'index'])->name('admin.stream-settings.index');
    Route::post('stream-settings', [App\Http\Controllers\Admin\StreamSettingsController::class, 'store'])->name('admin.stream-settings.store');
});
