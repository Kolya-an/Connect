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
        Schema::table('doctor_photos', function (Blueprint $table) {
            $table->string('photo_before');
            $table->string('photo_after');

            $table->enum('orientation', ['horizontal', 'vertical']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_photos', function (Blueprint $table) {
            $table->dropColumn('photo_before');
            $table->dropColumn('photo_after');
            $table->dropColumn('orientation');
        });
    }
};
