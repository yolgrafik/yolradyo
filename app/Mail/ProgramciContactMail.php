<?php

namespace App\Mail;

use App\Models\Programci;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProgramciContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Programci $programci,
        public string $senderName,
        public string $senderEmail,
        public string $messageBody
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Programcı İletişim: ' . $this->programci->ad,
            replyTo: [$this->senderEmail],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.programci-contact'
        );
    }
}
