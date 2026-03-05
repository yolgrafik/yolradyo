<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Config;

class MailHelper
{
    /**
     * Check if mail is configured for real delivery (not log/array).
     */
    public static function isRealMailConfigured(): bool
    {
        $mailer = Config::get('mail.default', 'log');
        return !in_array($mailer, ['log', 'array'], true);
    }

    /**
     * Get the error message when mail is not properly configured.
     */
    public static function getConfigErrorMessage(): string
    {
        return 'Mail ayarları yapılmamış. Lütfen SMTP ayarlarını kontrol edin.';
    }
}
