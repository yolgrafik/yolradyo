<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'E-posta veya şifre hatalı.',
        ])->onlyInput('email');
    }

    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $approvalRequired = app(\App\Services\SettingsService::class)->get('member_approval_required', true);
        $status = $approvalRequired ? 'pending' : 'approved';

        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'status' => $status,
        ]);

        Auth::login($user);

        $request->session()->regenerate();

        $message = $status === 'approved'
            ? 'Hesabınız oluşturuldu. Hoş geldiniz!'
            : 'Hesabınız oluşturuldu. Onaylandıktan sonra tüm özelliklere erişebilirsiniz.';

        return redirect()->intended('/')
            ->with('success', $message);
    }

    public function profile(): View
    {
        return view('auth.profile');
    }

    public function logout(\Illuminate\Http\Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
