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
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->string('service_display_type')->default('latest');
            $table->unsignedInteger('service_limit')->default(4);
            $table->json('manual_service_ids')->nullable();
            $table->string('procedure_display_type')->default('latest');
            $table->unsignedInteger('procedure_limit')->default(9);
            $table->json('manual_procedure_ids')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('homepage_settings', function (Blueprint $table) {
            $table->dropColumn('service_display_type');
            $table->dropColumn('service_limit');
            $table->dropColumn('manual_service_ids');
            $table->dropColumn('procedure_display_type');
            $table->dropColumn('procedure_limit');
            $table->dropColumn('manual_procedure_ids');
        });
    }
};
