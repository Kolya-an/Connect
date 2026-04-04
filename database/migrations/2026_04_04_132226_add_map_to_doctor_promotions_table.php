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
        Schema::table('doctor_promotions', function (Blueprint $table) {
            $table->boolean('map')->default(0)->after('date_to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('doctor_promotions', function (Blueprint $table) {
            $table->dropColumn('map');
        });
    }
};
