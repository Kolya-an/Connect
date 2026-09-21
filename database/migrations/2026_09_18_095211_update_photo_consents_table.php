<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('photo_consents', function (Blueprint $table) {
            if (!Schema::hasColumn('photo_consents', 'user_signature_id')) {
                $table->foreignId('user_signature_id')->nullable()->after('doctor_photo_id')->constrained('user_signatures')->nullOnDelete();
            }
            if (!Schema::hasColumn('photo_consents', 'diia_session_id')) {
                $table->string('diia_session_id')->nullable()->after('token');
            }
        });
    }

    public function down(): void
    {
        Schema::table('photo_consents', function (Blueprint $table) {
            $table->dropForeign(['user_signature_id']);
            $table->dropColumn(['user_signature_id', 'diia_session_id']);
        });
    }
};