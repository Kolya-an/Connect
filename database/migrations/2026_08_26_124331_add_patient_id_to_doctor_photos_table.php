<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('doctor_photos', function (Blueprint $table) {
            // Додаємо nullable, якщо старі фото можуть не мати пацієнта
            $table->foreignId('patient_id')->nullable()->after('doctor_id')->constrained('pacients')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('doctor_photos', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropColumn('patient_id');
        });
    }
};