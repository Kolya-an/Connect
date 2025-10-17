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
        Schema::create('pacients', function (Blueprint $table) {
            $table->id();
            $table->string('second_name')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate();
            $table->date('birthday')->nullable();
            $table->string('photo')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->enum('sex', ['male', 'female', 'nonbinary'])->default('female');
            $table->boolean('notification')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacients');
    }
};
