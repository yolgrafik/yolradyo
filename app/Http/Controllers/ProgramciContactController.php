<?php

namespace App\Http\Controllers;

use App\Mail\ProgramciContactMail;
use App\Models\Programci;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;

class ProgramciContactController extends Controller
{
    public function store(Request $request, string $slug)
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

        if (!$programci->email) {
            return back()->with('error', 'Bu programcıya iletişim bilgisi eklenmemiş.');
        }

        try {
            Mail::to($programci->email)->send(new ProgramciContactMail(
                $programci,
                $validated['name'],
                $validated['email'],
                $validated['message']
            ));
            RateLimiter::hit($key);
        } catch (\Throwable $e) {
            return back()->with('error', 'Mesaj gönderilemedi. Lütfen daha sonra tekrar deneyin.');
        }

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }
}
