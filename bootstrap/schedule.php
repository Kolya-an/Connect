<?php

use Illuminate\Console\Scheduling\Schedule;

return function (Schedule $schedule) {
    // Ежедневное удаление прошедших записей в 00:01 по Киеву
    $schedule->command('schedules:update')
        ->dailyAt('00:01')
        ->timezone('Europe/Kiev')
        ->withoutOverlapping()
        ->appendOutputTo(storage_path('logs/schedule-cleanup.log'));
};
