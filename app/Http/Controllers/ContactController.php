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
        return view('frontend.iletisim', [
            'pageTitle' => 'İletişim',
            'contactEmail' => $settings->get('contact_email'),
            'contactPhone' => $settings->get('contact_phone'),
            'addressText' => $settings->get('address_text'),
        ]);
    }

    public function store(ContactRequest $request, SettingsService $settings): RedirectResponse
    {
        if (!empty($request->validated('website'))) {
            return back()->with('success', 'Mesajınız gönderildi.');
        }

        $user = $request->user();
        if (!$user->isApproved()) {
            return back()->with('error', 'Mesaj gönderebilmek için hesabınızın onaylanması gerekiyor.');
        }

        MailHelper::applyConfig();

        if (!MailHelper::isRealMailConfigured()) {
            return back()->with('error', MailHelper::getConfigErrorMessage());
        }

        $recipient = MailHelper::getContactTo() ?: $settings->get('contact_email');
        if (!$recipient || !filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'İletişim e-posta adresi tanımlanmamış. Lütfen Mail Ayarları\'ndan "İletişim Alıcısı" ekleyin.');
        }

        $name = $user->name;
        $email = $user->email;
        $messageBody = $request->validated('message');

        $mailable = new ContactMessageMail($name, $email, $messageBody, 'İletişim Formu');

        try {
            Mail::to($recipient)->send($mailable);
            $status = 'sent';
        } catch (\Throwable $e) {
            Log::error('İletişim formu mail hatası', [
                'recipient' => $recipient,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            Message::create([
                'user_id' => $user->id,
                'programci_id' => null,
                'subject' => 'İletişim Formu',
                'message' => $messageBody,
                'status' => 'failed',
            ]);
            return back()->with('error', 'Mesaj gönderilemedi: ' . $e->getMessage());
        }

        Message::create([
            'user_id' => $user->id,
            'programci_id' => null,
            'subject' => 'İletişim Formu',
            'message' => $messageBody,
            'status' => $status,
        ]);

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }
}
