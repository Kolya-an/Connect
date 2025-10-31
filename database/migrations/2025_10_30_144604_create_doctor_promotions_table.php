<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctor_promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('old_price', 10, 2)->nullable();
            $table->decimal('new_price', 10, 2)->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_promotions');
    }
};
