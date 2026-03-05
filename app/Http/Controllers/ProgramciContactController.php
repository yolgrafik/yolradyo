<?php

namespace App\Http\Controllers;

use App\Helpers\MailHelper;
use App\Http\Requests\ProgramciContactRequest;
use App\Mail\ProgramciContactMail;
use App\Models\Message;
use App\Models\Programci;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProgramciContactController extends Controller
{
    public function store(ProgramciContactRequest $request, string $slug): RedirectResponse
    {
        $programci = Programci::where('slug', $slug)->active()->firstOrFail();
        $user = $request->user();

        if (!$user->isApproved()) {
            return back()->with('error', 'Hesabınız onay bekliyor.');
        }

        if (!empty($request->validated('website'))) {
            return back()->with('success', 'Mesajınız gönderildi.');
        }

        if (!$programci->email || !filter_var($programci->email, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'Bu programcı için e-posta tanımlı değil.');
        }

        MailHelper::applyConfig();

        if (!MailHelper::isRealMailConfigured()) {
            return back()->with('error', MailHelper::getConfigErrorMessage());
        }

        $name = $user->name;
        $email = $user->email;
        $messageBody = $request->validated('message');
        $mailable = new ProgramciContactMail($programci, $name, $email, $messageBody);

        try {
            Mail::to($programci->email)->send($mailable);
            $status = 'sent';
        } catch (\Throwable $e) {
            Log::error('Programcı iletişim mail hatası', [
                'programci' => $programci->slug,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            Message::create([
                'user_id' => $user->id,
                'programci_id' => $programci->id,
                'subject' => 'Programcı İletişim: ' . $programci->ad,
                'message' => $messageBody,
                'status' => 'failed',
            ]);
            return back()->with('error', 'Mesaj gönderilemedi: ' . $e->getMessage());
        }

        Message::create([
            'user_id' => $user->id,
            'programci_id' => $programci->id,
            'subject' => 'Programcı İletişim: ' . $programci->ad,
            'message' => $messageBody,
            'status' => $status,
        ]);

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }
}
