<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResetByAdmin extends Notification implements ShouldQueue
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
            ->subject('Şifreniz güncellendi')
            ->greeting('Merhaba ' . $notifiable->name . ',')
            ->line('Hesabınızın şifresi sitemiz yöneticisi tarafından sıfırlandı.')
            ->line('Yeni şifrenizle giriş yapabilirsiniz. Güvenliğiniz için ilk girişinizde şifrenizi değiştirmenizi öneririz.')
            ->action('Giriş Yap', url('/login'));
    }
}
