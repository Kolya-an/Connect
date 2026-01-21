<?php

namespace App\Mail;

use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsToSubscribersMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public News $news
    ) {}

    public function build(): self
    {
        return $this
            ->subject($this->news->title)
            ->view('emails.news-to-subscribers');
    }
}
