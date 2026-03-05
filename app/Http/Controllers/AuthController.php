<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('auth.login');
    }

    public function showForgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        try {
            MailHelper::applyConfig();
            Password::sendResetLink($request->only('email'));
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning('Password reset email failed: ' . $e->getMessage());
        }

        return back()->with('status', 'E-posta adresinize şifre sıfırlama bağlantısı gönderdik. Görmediyseniz spam klasörünü kontrol edin.');
    }

    public function showResetPassword(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', 'Şifreniz güncellendi. Giriş yapabilirsiniz.');
        }

        return back()->withErrors(['email' => __('Şifre sıfırlama bağlantısı geçersiz veya süresi dolmuş.')]);
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
