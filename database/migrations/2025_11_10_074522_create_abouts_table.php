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
        Schema::create('abouts', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('meta_name')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('slug')->nullable()->required();
            $table->string('first_name')->nullable();
            $table->string('first_sentience')->nullable();
            $table->string('second_sentience')->nullable();
            $table->text('second_text')->nullable();
            $table->string('grey_name')->nullable();
            $table->string('grey_title')->nullable();
            $table->text('grey_text')->nullable();
            $table->text('action_text')->nullable();
            $table->text('rating_text')->nullable();
            $table->text('photobank_text')->nullable();
            $table->text('our_text')->nullable();
            $table->string('our_rose_text')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abouts');
    }
};
