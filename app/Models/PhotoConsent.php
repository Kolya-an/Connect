<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PhotoConsent extends Model
{
    protected $fillable = [
        'doctor_photo_id',
        'token',
        'status',
        'signed_at',
        'signer_info',
        'pdf_path',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
        'signer_info' => 'array',
    ];

    public function photo(): BelongsTo
    {
        return $this->belongsTo(DoctorPhoto::class, 'doctor_photo_id');
    }

    public function userSignature()
    {
        // Зв'язуємо PhotoConsent та UserSignature за спільним полем token
        return $this->belongsTo(UserSignature::class, 'token', 'token');
    }

    public function doctorPhoto()
    {
        return $this->belongsTo(DoctorPhoto::class, 'doctor_photo_id');
    }
}
