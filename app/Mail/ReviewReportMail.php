<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReviewReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $reportText,
        public string $reporterName,
        public string $doctorName,
        public string $reviewDate,
        public string $reviewText
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Скарга на відгук про лікаря',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.review-report',
        );
    }
}