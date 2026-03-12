<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $otp,
        public string $nama,
        public string $tipe = 'login'
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->tipe === 'verifikasi'
            ? '[BatusangkarLapor] Verifikasi Email Anda'
            : '[BatusangkarLapor] Kode OTP Login';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.otp');
    }
}