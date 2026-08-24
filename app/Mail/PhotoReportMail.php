<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PhotoReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $reportText,
        public string $reporterName,
        public string $doctorName,
        public string $photoBefore,
        public string $photoAfter
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Скарга на фото роботи лікаря',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.photo-report',
        );
    }
}