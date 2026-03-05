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
        $user = auth()->user();
        return view('frontend.iletisim', [
            'pageTitle' => 'İletişim',
            'contactMobile' => $settings->get('contact_mobile') ?: $settings->get('contact_phone'),
            'contactPhone' => $settings->get('contact_phone'),
            'contactEmail' => $settings->get('contact_email'),
            'contactFax' => $settings->get('contact_fax'),
            'addressText' => $settings->get('address_text') ?: 'Bergischer Ring 38, 58095 Hagen, Almanya',
            'prefillName' => $user?->name,
            'prefillEmail' => $user?->email,
        ]);
    }

    public function store(ContactRequest $request, SettingsService $settings): RedirectResponse
    {
        if (!empty($request->validated('website'))) {
            return back()->with('success', 'Mesajınız gönderildi.');
        }

        $user = $request->user();
        if ($user && !$user->isApproved()) {
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

        $validated = $request->validated();
        $name = $validated['name'];
        $email = $validated['email'];
        $messageBody = $validated['message'];
        $subjectLine = $validated['subject'] ?? null;
        $phone = $validated['phone'] ?? null;
        $whereFound = $validated['where_found'] ?? null;

        $mailable = new ContactMessageMail(
            $name,
            $email,
            $messageBody,
            'İletişim Formu',
            $phone,
            $subjectLine,
            $whereFound ? array_values($whereFound) : null,
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
            Message::create([
                'user_id' => $user?->id,
                'programci_id' => null,
                'subject' => $subjectLine ?: 'İletişim Formu',
                'message' => "Ad: $name\nE-posta: $email\nTelefon: " . ($phone ?: '-') . "\n\n$messageBody",
                'status' => 'failed',
            ]);
            return back()->with('error', 'Mesaj gönderilemedi: ' . $e->getMessage());
        }

        Message::create([
            'user_id' => $user?->id,
            'programci_id' => null,
            'subject' => $subjectLine ?: 'İletişim Formu',
            'message' => "Ad: $name\nE-posta: $email\nTelefon: " . ($phone ?: '-') . "\n\n$messageBody",
            'status' => $status,
        ]);

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }
}
