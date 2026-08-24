<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            // Змінюємо тип колонки на TEXT (до 65,535 символів) або LONGTEXT
            $table->text('disclamer')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->string('disclamer')->nullable()->change();
        });
    }
};