<?php
// app/Providers/ConsoleServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->commands([
            \App\Console\Commands\UpdateDoctorSchedules::class,
        ]);
    }
}
