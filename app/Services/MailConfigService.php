<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;

class MailConfigService
{
    public function __construct(
        protected SettingsService $settings
    ) {}

    /**
     * Apply mail config from DB (site_settings) to Laravel Config.
     * DB values override env when present.
     */
    public function apply(): void
    {
        $host = $this->settings->get('mail_host') ?: config('mail.mailers.smtp.host');
        $port = $this->settings->get('mail_port') ?: config('mail.mailers.smtp.port');
        $username = $this->settings->get('mail_username');
        $password = $this->settings->get('mail_password');
        $encryption = $this->settings->get('mail_encryption');
        $fromAddress = $this->settings->get('mail_from_address') ?: config('mail.from.address');
        $fromName = $this->settings->get('mail_from_name') ?: config('mail.from.name');
        $mailer = $this->settings->get('mail_mailer') ?: 'smtp';

        Config::set('mail.default', $mailer);
        Config::set('mail.from.address', $fromAddress);
        Config::set('mail.from.name', $fromName);
        Config::set('mail.contact_to', $this->settings->get('mail_contact_to') ?: config('mail.contact_to'));

        Config::set('mail.mailers.smtp', array_merge(Config::get('mail.mailers.smtp', []), [
            'transport' => 'smtp',
            'host' => $host,
            'port' => (int) $port,
            'username' => $username ?: null,
            'password' => $password ?: null,
            'encryption' => in_array($encryption, ['tls', 'ssl'], true) ? $encryption : null,
            'timeout' => null,
        ]));
    }

    /**
     * Check if mail settings are complete for sending.
     */
    public function isConfigured(): bool
    {
        $this->apply();

        $host = Config::get('mail.mailers.smtp.host');
        $port = Config::get('mail.mailers.smtp.port');
        $username = Config::get('mail.mailers.smtp.username');
        $password = Config::get('mail.mailers.smtp.password');
        $fromAddress = Config::get('mail.from.address');

        return !empty($host) && !empty($port) && !empty($username) && !empty($password) && !empty($fromAddress);
    }
}
