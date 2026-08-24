<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DoctorReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $reportText,
        public string $reporterName,
        public string $doctorName
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Скарга на лікаря',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.doctor-report',
        );
    }
}