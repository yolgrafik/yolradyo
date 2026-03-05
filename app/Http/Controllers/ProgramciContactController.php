<?php

namespace App\Http\Controllers;

use App\Mail\ProgramciContactMail;
use App\Models\Programci;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ProgramciContactController extends Controller
{
    public function store(Request $request, string $slug, SettingsService $settings)
    {
        $programci = Programci::where('slug', $slug)->active()->firstOrFail();

        $key = 'programci-contact:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->with('error', 'Çok fazla deneme. Lütfen daha sonra tekrar deneyin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:2000',
            'website' => 'nullable|string|max:1', // honeypot
        ]);

        if (!empty($validated['website'])) {
            return back()->with('success', 'Mesajınız gönderildi.');
        }

        $recipient = $programci->email ?: $settings->get('contact_email');
        if (!$recipient || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'Bu programcıya iletişim bilgisi eklenmemiş.');
        }

        $mailable = new ProgramciContactMail(
            $programci,
            $validated['name'],
            $validated['email'],
            $validated['message']
        );

        try {
            Mail::to($recipient)->send($mailable);
            RateLimiter::hit($key);
        } catch (\Throwable $e) {
            Log::error('Programcı iletişim mail hatası', [
                'programci' => $programci->slug,
                'recipient' => $recipient,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $fallbackEmail = $settings->get('contact_email');
            if ($fallbackEmail && filter_var($fallbackEmail, FILTER_VALIDATE_EMAIL) && $fallbackEmail !== $recipient) {
                try {
                    Mail::to($fallbackEmail)->send($mailable);
                    RateLimiter::hit($key);
                    return back()->with('success', 'Mesajınız başarıyla gönderildi.');
                } catch (\Throwable $e2) {
                    Log::error('Programcı iletişim fallback mail hatası', ['error' => $e2->getMessage()]);
                }
            }

            return back()->with('error', 'Mesaj gönderilemedi. Lütfen daha sonra tekrar deneyin.');
        }

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }
}
