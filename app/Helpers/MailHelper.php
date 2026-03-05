<?php

namespace App\Helpers;

use App\Services\MailConfigService;
use App\Services\SettingsService;
use Illuminate\Support\Facades\App;

class MailHelper
{
    /**
     * Check if mail is configured for real delivery.
     * Uses DB settings (site_settings) when available.
     */
    public static function isRealMailConfigured(): bool
    {
        $service = App::make(MailConfigService::class);
        return $service->isConfigured();
    }

    /**
     * Apply mail config from DB before sending.
     * Call this before Mail::send() to ensure DB settings are used.
     */
    public static function applyConfig(): void
    {
        App::make(MailConfigService::class)->apply();
    }

    /**
     * Get the error message when mail is not properly configured.
     */
    public static function getConfigErrorMessage(): string
    {
        return 'Mail ayarları yapılmamış. Lütfen SMTP ayarlarını kontrol edin.';
    }

    /**
     * Get contact form recipient: mail_contact_to (DB) > contact_email (site_settings).
     */
    public static function getContactTo(): ?string
    {
        static::applyConfig();
        $settings = App::make(SettingsService::class);
        $to = $settings->get('mail_contact_to') ?: config('mail.contact_to') ?: $settings->get('contact_email');
        return $to && filter_var($to, FILTER_VALIDATE_EMAIL) ? $to : null;
    }
}
