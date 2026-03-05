<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminSuperAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return redirect()->route('admin.login')->with('error', 'Giriş yapmanız gerekiyor.');
        }
        $admin = Admin::find($adminId);
        if (!$admin) {
            session()->forget(['admin_logged_in', 'admin_id']);
            return redirect()->route('admin.login');
        }
        if (!$admin->isSuperAdmin()) {
            abort(403, 'Bu işlem için Super Admin yetkisi gereklidir.');
        }
        return $next($request);
    }
}
