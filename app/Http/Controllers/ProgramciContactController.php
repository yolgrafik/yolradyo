<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Http\Requests\ProgramciContactRequest;
use App\Mail\ProgramciContactMail;
use App\Models\Programci;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ProgramciContactController extends Controller
{
    public function store(ProgramciContactRequest $request, string $slug): RedirectResponse
    {
        $programci = Programci::where('slug', $slug)->active()->firstOrFail();

        $key = 'programci-contact:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->with('error', 'Çok fazla deneme. Lütfen daha sonra tekrar deneyin.');
        }

        if (!empty($request->validated('website'))) {
            return back()->with('success', 'Mesajınız gönderildi.');
        }

        if (!$programci->email || !filter_var($programci->email, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'Bu programcıya iletişim bilgisi eklenmemiş.');
        }

        if (!MailHelper::isRealMailConfigured()) {
            Log::warning('Programcı iletişim: Mail log/array modunda, gerçek gönderim yapılamıyor.', [
                'programci' => $programci->slug,
            ]);
            return back()->with('error', MailHelper::getConfigErrorMessage());
        }

        $validated = $request->validated();
        $mailable = new ProgramciContactMail(
            $programci,
            $validated['name'],
            $validated['email'],
            $validated['message']
        );

        try {
            Mail::to($programci->email)->send($mailable);
            RateLimiter::hit($key);
        } catch (\Throwable $e) {
            Log::error('Programcı iletişim mail hatası', [
                'programci' => $programci->slug,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Mesaj gönderilemedi. Lütfen daha sonra tekrar deneyin.');
        }

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }
}
