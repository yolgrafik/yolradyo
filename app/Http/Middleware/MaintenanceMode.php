<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        $enabled = app(\App\Services\SettingsService::class)->get('maintenance_mode', false);
        if (!$enabled) {
            return $next($request);
        }

        if ($request->is('admin/*') && session('admin_logged_in')) {
            return $next($request);
        }

        if ($request->is('admin/login')) {
            return $next($request);
        }

        return response()->view('maintenance', [], 503);
    }
}
