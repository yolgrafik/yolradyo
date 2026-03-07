<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\ActivityLogger;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Schema::hasTable('admins')) {
            $admin = Admin::where('email', $request->email)->first();
            if ($admin && $admin->is_active && \Illuminate\Support\Facades\Hash::check($request->password, $admin->password)) {
                $admin->update(['last_login_at' => now()]);
                session([
                    'admin_logged_in' => true,
                    'admin_id' => $admin->id,
                ]);
                ActivityLogger::log('admin.login', ['admin_id' => $admin->id, 'email' => $admin->email]);
                return redirect('/admin/dashboard');
            }
        }

        if ($request->email === env('ADMIN_EMAIL') && $request->password === env('ADMIN_PASSWORD')) {
            session(['admin_logged_in' => true]);
            if (Schema::hasTable('admins')) {
                $admin = Admin::where('email', $request->email)->first();
                if ($admin) {
                    session(['admin_id' => $admin->id]);
                    $admin->update(['last_login_at' => now()]);
                    ActivityLogger::log('admin.login', ['admin_id' => $admin->id, 'email' => $admin->email]);
                }
            }
            return redirect('/admin/dashboard');
        }

        return back()->with('error', 'Bilgiler hatali');
    }
}
