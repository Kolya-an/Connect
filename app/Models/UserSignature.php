<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\DoctorPhoto;

class UserSignature extends Model
{
    protected $fillable = [
        'user_id',
        'doctor_id',
        'photo_id',
        'title',
        'description',
        'token',
        'status',
        'signed_at',
        'signature_data',
        'pdf_path',
        'is_read',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
        'signature_data' => 'array',
        'is_read' => 'boolean',
    ];

    // Зв'язок із користувачем (пацієнтом)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Зв'язок із лікарем
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function photoConsent()
    {
        return $this->hasOne(PhotoConsent::class, 'user_signature_id');
    }
    
    // Зв'язок із фото лікаря
    public function doctorPhoto(): BelongsTo
    {
        return $this->belongsTo(DoctorPhoto::class);
    }
}