<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum AppointmentStatus: string implements HasLabel
{
    case Booking = 'booking';
    case Confirmed = 'confirmed';
    case Completed = 'completed';
    case Canceled = 'canceled';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Booking => 'Бронювання',
            self::Confirmed => 'Підтверждено',
            self::Completed => 'Завершено',
            self::Canceled => 'Відмінено',
        };
    }
}
