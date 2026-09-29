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
        Schema::table('photo_consents', function (Blueprint $table) {
            $table->string('file_document')->nullable()->after('pdf_path');
        });
    }

    public function down(): void
    {
        Schema::table('photo_consents', function (Blueprint $table) {
            $table->dropColumn('file_document');
        });
    }
};
