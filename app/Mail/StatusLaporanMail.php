<?php

namespace App\Mail;

use App\Models\Pengaduan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusLaporanMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Pengaduan $pengaduan,
        public string $statusLama,
        public ?string $keterangan = null
    ) {}

    public function envelope(): Envelope
    {
        $label = $pengaduan->status_badge['label'] ?? $this->pengaduan->status;
        return new Envelope(
            subject: "[BatusangkarLapor] Status Laporan Diperbarui — {$label}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.status-laporan',
            with: [
                'pengaduan'  => $this->pengaduan,
                'statusLama' => $this->statusLama,
                'keterangan' => $this->keterangan,
            ]
        );
    }
}