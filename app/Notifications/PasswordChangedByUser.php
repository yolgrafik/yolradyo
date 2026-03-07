<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordChangedByUser extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $siteName
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Şifreniz değiştirildi')
            ->greeting('Merhaba ' . $notifiable->name . ',')
            ->line('Hesabınızın şifresi başarıyla güncellendi.')
            ->line('Bu işlemi siz yapmadıysanız, lütfen hemen yönetici ile iletişime geçin.')
            ->action('Giriş Yap', url('/login'));
    }
}
