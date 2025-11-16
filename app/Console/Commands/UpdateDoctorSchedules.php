<?php

namespace App\Console\Commands;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Console\Command;

class UpdateDoctorSchedules extends Command
{
    protected $signature = 'schedules:update';
    protected $description = 'Remove past schedule records';

    public function handle(): void
    {
        $this->info('Removing past schedule records...');

        // Удаляем только записи прошедших дней
        $deleted = DoctorSchedule::where('date', '<', now()->format('Y-m-d'))->delete();

        $this->info("Successfully deleted {$deleted} past records.");

        // НЕ создаем новые записи автоматически
        // Записи будут создаваться только при клике на кнопки
    }
}
