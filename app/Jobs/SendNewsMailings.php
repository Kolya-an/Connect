<?php

namespace App\Jobs;

use App\Mail\NewsNotificationMail;
use App\Models\News;
use App\Models\Subscriber;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendNewsMailings implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public News $news;

    public function __construct(News $news)
    {
        $this->news = $news;
    }

    public function handle(): void
    {
        $categoryId = $this->news->category_id;
        $recipients = collect();

        // 1. Получаем зарегистрированных пользователей с ролью 'patient'
        $patientEmails = User::whereHas('roles', fn ($query) => $query->where('name', 'patient'))
            ->pluck('email');

        // 2. Логика рассылки
        if ($categoryId === 2) {
            // Категория "Новини": Зарегистрированные (patient) И Незарегистрированные (subscribers)
            $recipients = $recipients->merge($patientEmails);

            // Получаем email незарегистрированных подписчиков
            $subscriberEmails = Subscriber::pluck('email');
            $recipients = $recipients->merge($subscriberEmails);

        } elseif ($categoryId === 4) {
            // Категория "Для лікарів": Только Зарегистрированные (patient)
            $recipients = $recipients->merge($patientEmails);
        }

        $uniqueRecipients = $recipients->unique()->filter();

        if ($uniqueRecipients->isNotEmpty()) {
            // Отправляем почту всем уникальным получателям
            // Используем BCC для массовой рассылки
            Mail::bcc($uniqueRecipients->toArray())->send(new NewsNotificationMail($this->news));
        }
    }
}
