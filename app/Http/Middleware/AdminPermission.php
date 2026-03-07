<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('admin.login')->with('error', 'Giris yapmaniz gerekiyor.');
        }
        $admin = Admin::find($adminId);
        if (!$admin) {
            session()->forget(['admin_logged_in', 'admin_id']);
            return redirect()->route('admin.login');
        }
        if ($admin->isSuperAdmin() || $admin->hasPermission($permission)) {
            return $next($request);
        }
        abort(403, 'Bu islem icin yetkiniz yok.');
    }
}
