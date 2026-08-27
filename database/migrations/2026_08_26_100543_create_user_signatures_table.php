<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Пацієнт
            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete('set null'); // Лікар
            $table->string('title');                                          // Заголовок запису
            $table->text('description')->nullable();                          // Опис або примітка
            $table->string('token', 64)->unique();                            // Токен для посилання на підпис
            $table->enum('status', ['pending', 'signed', 'declined'])->default('pending'); // Статус підпису
            $table->timestamp('signed_at')->nullable();                       // Дата та час підписання
            $table->json('signature_data')->nullable();                       // Дані КЕП (ПІБ, ДРФО тощо)
            $table->string('pdf_path')->nullable();                           // Шлях до підписаного PDF
            $table->boolean('is_read')->default(false);                       // Переглянуто в кабінеті
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_signatures');
    }
};