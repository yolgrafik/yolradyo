<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Notifications\PasswordChangedByUser;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function show(): View
    {
        $user = auth()->user();
        return view('auth.profile-edit', compact('user'));
    }

    public function update(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
            $user->save();

            try {
                MailHelper::applyConfig();
                if (MailHelper::isRealMailConfigured()) {
                    $siteName = app(SettingsService::class)->get('site_name') ?: config('app.name');
                    $user->notify(new PasswordChangedByUser($siteName));
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::warning('Password changed notification failed: ' . $e->getMessage());
            }
        } else {
            $user->save();
        }

        return redirect()->route('profile.edit')->with('success', 'Profil bilgileriniz güncellendi.');
    }
}
