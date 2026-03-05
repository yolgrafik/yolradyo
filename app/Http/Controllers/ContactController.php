<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMessageMail;
use App\Models\Message;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
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
        if (!empty($request->validated('website'))) {
            return back()->with('success', 'Mesajınız gönderildi.');
        }

        $user = $request->user();
        $name = $user->name;
        $email = $user->email;
        $messageBody = $request->validated('message');

        $recipient = config('mail.contact_to') ?: $settings->get('contact_email');
        if (!$recipient || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'İletişim e-posta adresi tanımlanmamış. Lütfen site yöneticisi ile iletişime geçin.');
        }

        if (!MailHelper::isRealMailConfigured()) {
            Log::warning('İletişim formu: Mail log/array modunda, gerçek gönderim yapılamıyor.', [
                'recipient' => $recipient,
            ]);
            $status = 'failed';
        } else {
            $mailable = new ContactMessageMail(
                $name,
                $email,
                $messageBody,
                'İletişim Formu'
            );

            try {
                Mail::to($recipient)->send($mailable);
                $status = 'sent';
            } catch (\Throwable $e) {
                Log::error('İletişim formu mail hatası', [
                    'recipient' => $recipient,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $status = 'failed';
            }
        }

        Message::create([
            'user_id' => $user->id,
            'programci_id' => null,
            'subject' => 'İletişim Formu',
            'message' => $messageBody,
            'status' => $status,
        ]);

        if ($status === 'failed') {
            return back()->with('error', MailHelper::isRealMailConfigured() ? 'Mesaj gönderilemedi. Lütfen daha sonra tekrar deneyin.' : MailHelper::getConfigErrorMessage());
        }

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }
}
