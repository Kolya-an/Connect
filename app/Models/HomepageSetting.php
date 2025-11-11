<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageSetting extends Model
{
    protected $fillable = [
        'title',
        'about_name',
        'about_title',
        'about_text',
        'news_display_type',
        'news_limit',
        'manual_news_ids',
        'service_display_type',
        'service_limit',
        'manual_service_ids',
        'procedure_display_type',
        'procedure_limit',
        'manual_procedure_ids',
        'doctor_id',
        'doctors_ids',
    ];
    protected $casts = [
        'manual_news_ids' => 'array',
        'manual_service_ids' => 'array',
        'manual_procedure_ids' => 'array',
        'doctors_ids' => 'array',
    ];
}
