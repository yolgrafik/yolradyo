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
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class MailSettingsController extends Controller
{
    protected function isSuperAdmin(): bool
    {
        $adminId = session('admin_id');
        if (!$adminId) {
            return false;
        }
        $admin = \App\Models\Admin::find($adminId);
        return $admin && $admin->isSuperAdmin();
    }

    public function __construct(
        protected SettingsService $settings,
        protected MailConfigService $mailConfig
    ) {}

    protected function getMailSetting(string $key, mixed $default = ''): mixed
    {
        if (!Schema::hasTable('site_settings')) {
            return $default;
        }
        try {
            return $this->settings->get($key, $default);
        } catch (\Throwable $e) {
            Log::warning('MailSettingsController::getMailSetting failed', ['key' => $key, 'error' => $e->getMessage()]);
            return $default;
        }
    }

    public function index(): View
    {
        return view('admin.mail-settings.index', [
            'canEdit' => $this->isSuperAdmin(),
            'mailMailer' => $this->getMailSetting('mail_mailer', 'smtp'),
            'mailHost' => $this->getMailSetting('mail_host', ''),
            'mailPort' => $this->getMailSetting('mail_port', '587'),
            'mailUsername' => $this->getMailSetting('mail_username', ''),
            'hasPassword' => !empty($this->getMailSetting('mail_password')),
            'mailEncryption' => $this->getMailSetting('mail_encryption', 'tls'),
            'mailFromAddress' => $this->getMailSetting('mail_from_address', ''),
            'mailFromName' => $this->getMailSetting('mail_from_name', ''),
            'mailContactTo' => $this->getMailSetting('mail_contact_to', ''),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if (!Schema::hasTable('site_settings')) {
            return back()->with('error', 'site_settings tablosu bulunamadı. Lütfen migration\'ları çalıştırın: php artisan migrate');
        }

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
        if (empty($this->getMailSetting('mail_password'))) {
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
