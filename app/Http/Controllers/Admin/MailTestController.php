<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use App\Models\Admin;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class MailTestController extends Controller
{
    public function sendTest(): RedirectResponse
    {
        if (!MailHelper::isRealMailConfigured()) {
            return back()->with('error', MailHelper::getConfigErrorMessage());
        }

        $adminEmail = session('admin_id')
            ? Admin::find(session('admin_id'))?->email
            : null;
        $adminEmail = $adminEmail ?: env('ADMIN_EMAIL');

        if (!$adminEmail || !filter_var($adminEmail, FILTER_VALIDATE_EMAIL)) {
            return back()->with('error', 'Test e-postası gönderilecek geçerli bir admin e-posta adresi bulunamadı.');
        }

        try {
            Mail::to($adminEmail)->send(new ContactMessageMail(
                'Test Gönderen',
                config('mail.from.address'),
                'Bu bir test mesajıdır. Mail ayarlarınız doğru çalışıyor.',
                'Mail Test'
            ));
        } catch (\Throwable $e) {
            Log::error('Admin mail test hatası', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Test e-postası gönderilemedi: ' . $e->getMessage());
        }

        return back()->with('success', 'Test e-postası ' . $adminEmail . ' adresine gönderildi.');
    }
}
