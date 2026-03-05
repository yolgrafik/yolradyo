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

        if (!empty($request->validated('website'))) {
            return back()->with('success', 'Mesajınız gönderildi.');
        }

        if (!$programci->email || !filter_var($programci->email, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'Bu programcıya iletişim bilgisi eklenmemiş.');
        }

        $name = $user->name;
        $email = $user->email;
        $messageBody = $request->validated('message');

        if (!MailHelper::isRealMailConfigured()) {
            Log::warning('Programcı iletişim: Mail log/array modunda, gerçek gönderim yapılamıyor.', [
                'programci' => $programci->slug,
            ]);
            $status = 'failed';
        } else {
            $mailable = new ProgramciContactMail(
                $programci,
                $name,
                $email,
                $messageBody
            );

            try {
                Mail::to($programci->email)->send($mailable);
                $status = 'sent';
            } catch (\Throwable $e) {
                Log::error('Programcı iletişim mail hatası', [
                    'programci' => $programci->slug,
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                $status = 'failed';
            }
        }

        Message::create([
            'user_id' => $user->id,
            'programci_id' => $programci->id,
            'subject' => 'Programcı İletişim: ' . $programci->ad,
            'message' => $messageBody,
            'status' => $status,
        ]);

        if ($status === 'failed') {
            return back()->with('error', MailHelper::isRealMailConfigured() ? 'Mesaj gönderilemedi. Lütfen daha sonra tekrar deneyin.' : MailHelper::getConfigErrorMessage());
        }

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }
}
