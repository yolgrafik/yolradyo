<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\MailHelper;
use App\Http\Controllers\Controller;
use App\Mail\ContactMessageMail;
use App\Services\MailConfigService;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class MailSettingsController extends Controller
{
    public function __construct(
        protected SettingsService $settings,
        protected MailConfigService $mailConfig
    ) {}

    public function index(): View
    {
        return view('admin.mail-settings.index', [
            'mailMailer' => $this->settings->get('mail_mailer', 'smtp'),
            'mailHost' => $this->settings->get('mail_host', ''),
            'mailPort' => $this->settings->get('mail_port', '587'),
            'mailUsername' => $this->settings->get('mail_username', ''),
            'mailPassword' => $this->settings->get('mail_password', ''),
            'mailEncryption' => $this->settings->get('mail_encryption', 'tls'),
            'mailFromAddress' => $this->settings->get('mail_from_address', ''),
            'mailFromName' => $this->settings->get('mail_from_name', ''),
            'mailContactTo' => $this->settings->get('mail_contact_to', ''),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $rules = [
            'mail_mailer' => 'required|in:smtp',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|string|max:10',
            'mail_username' => 'required|string|max:255',
            'mail_password' => 'nullable|string|max:500',
            'mail_encryption' => 'nullable|in:tls,ssl,',
            'mail_from_address' => 'required|email',
            'mail_from_name' => 'required|string|max:255',
            'mail_contact_to' => 'required|email',
        ];
        if (!$this->settings->get('mail_password')) {
            $rules['mail_password'] = 'required|string|max:500';
        }
        $validated = $request->validate($rules, [
            'mail_host.required' => 'SMTP sunucusu zorunludur.',
            'mail_username.required' => 'Kullanıcı adı zorunludur.',
            'mail_password.required' => 'Şifre zorunludur.',
            'mail_from_address.required' => 'Gönderen e-posta zorunludur.',
            'mail_from_name.required' => 'Gönderen adı zorunludur.',
            'mail_contact_to.required' => 'İletişim alıcısı zorunludur.',
        ]);

        foreach ($validated as $key => $value) {
            if ($key === 'mail_password' && empty($value)) {
                continue;
            }
            $this->settings->set($key, $value ?: '', 'text');
        }

        if ($request->has('mail_encryption')) {
            $this->settings->set('mail_encryption', $request->mail_encryption ?: '', 'text');
        }

        try {
            Artisan::call('config:clear');
            Artisan::call('cache:clear');
        } catch (\Throwable $e) {
            // Continue - settings saved
        }

        return back()->with('success', 'Mail ayarları kaydedildi. Config ve cache temizlendi.');
    }

    public function sendTest(Request $request): RedirectResponse
    {
        $request->validate([
            'test_email' => 'required|email',
        ], [
            'test_email.required' => 'Test e-posta adresi girin.',
            'test_email.email' => 'Geçerli bir e-posta adresi girin.',
        ]);

        $this->mailConfig->apply();

        if (!$this->mailConfig->isConfigured()) {
            return back()->with('error', MailHelper::getConfigErrorMessage());
        }

        $testEmail = $request->test_email;

        try {
            Mail::to($testEmail)->send(new ContactMessageMail(
                'Test Gönderen',
                config('mail.from.address'),
                'Bu bir test mesajıdır. Mail ayarlarınız doğru çalışıyor.',
                'Mail Test'
            ));
        } catch (\Throwable $e) {
            Log::error('Admin mail test hatası', [
                'to' => $testEmail,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            $shortMsg = strlen($e->getMessage()) > 120 ? substr($e->getMessage(), 0, 117) . '...' : $e->getMessage();
            return back()->with('error', 'Test e-postası gönderilemedi: ' . $shortMsg);
        }

        return back()->with('success', 'Test e-postası ' . $testEmail . ' adresine başarıyla gönderildi.');
    }
}
