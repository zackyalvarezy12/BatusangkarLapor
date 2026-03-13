<?php

namespace App\Mail;

use App\Models\Kritik;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BalasanKritikMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Kritik $kritik
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Balasan atas ' . ucfirst($this->kritik->jenis) . ' Anda — BatusangkarLapor',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.balasan-kritik',
            with: [
                'kritik' => $this->kritik,
            ],
        );
    }
}