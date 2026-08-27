<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('photo_consents', function (Blueprint $table) {
            $table->id();
            
            // Зв'язок із таблицею фотографій лікаря
            $table->foreignId('doctor_photo_id')
                  ->constrained('doctor_photos')
                  ->onDelete('cascade');

            // Унікальний безпечний токен для посилання (наприклад: 64 символи)
            $table->string('token', 64)->unique();

            // Статус згоди: pending (очікує), signed (підписано), declined (відхилено)
            $table->enum('status', ['pending', 'signed', 'declined'])->default('pending');

            // Дані підписанта та підпису
            $table->timestamp('signed_at')->nullable();
            $table->json('signer_info')->nullable(); // ПІБ, ДРФО пацієнта з КЕП
            $table->string('pdf_path')->nullable();   // Шлях до згенерованого PDF згоду у storage

            $table->timestamps();
        });

        // Додаємо статус публікації в таблицю фотографій (якщо ще немає)
        Schema::table('doctor_photos', function (Blueprint $table) {
            if (!Schema::hasColumn('doctor_photos', 'is_published')) {
                $table->boolean('is_published')->default(false)->after('product');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('photo_consents');
    }
};
