<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessageMail;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(SettingsService $settings): View
    {
        $contactEmail = $settings->get('contact_email');
        return view('frontend.iletisim', [
            'pageTitle' => 'İletişim',
            'contactEmail' => $contactEmail,
        ]);
    }

    public function store(ContactRequest $request, SettingsService $settings): RedirectResponse
    {
        $key = 'contact-form:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return back()->with('error', 'Çok fazla deneme. Lütfen daha sonra tekrar deneyin.');
        }

        if (!empty($request->validated('website'))) {
            return back()->with('success', 'Mesajınız gönderildi.');
        }

        $recipient = config('mail.contact_to') ?: $settings->get('contact_email');
        if (!$recipient || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'İletişim e-posta adresi tanımlanmamış. Lütfen site yöneticisi ile iletişime geçin.');
        }

        if (!MailHelper::isRealMailConfigured()) {
            Log::warning('İletişim formu: Mail log/array modunda, gerçek gönderim yapılamıyor.', [
                'recipient' => $recipient,
            ]);
            return back()->with('error', MailHelper::getConfigErrorMessage());
        }

        $validated = $request->validated();
        $mailable = new ContactMessageMail(
            $validated['name'],
            $validated['email'],
            $validated['message'],
            'İletişim Formu'
        );

        try {
            Mail::to($recipient)->send($mailable);
            RateLimiter::hit($key);
        } catch (\Throwable $e) {
            Log::error('İletişim formu mail hatası', [
                'recipient' => $recipient,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Mesaj gönderilemedi. Lütfen daha sonra tekrar deneyin.');
        }

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }
}
