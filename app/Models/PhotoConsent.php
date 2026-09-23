<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Casts\Attribute;

class PhotoConsent extends Model
{
    protected $guarded = [];

    protected $fillable = [
        'doctor_photo_id',
        'token',
        'status',
        'signed_at',
        'signer_info',
        'pdf_path',
        'diia_session_id',
    ];

    protected $casts = [
        'signed_at' => 'datetime',
        'signer_info' => 'array',
        'status' => \App\Enums\ConsentStatus::class,
    ];

    public function photo(): BelongsTo
    {
        return $this->belongsTo(DoctorPhoto::class, 'doctor_photo_id');
    }

    public function userSignature()
    {
        return $this->belongsTo(UserSignature::class, 'user_signature_id');
    }

    public function doctorPhoto()
    {
        return $this->belongsTo(DoctorPhoto::class, 'doctor_photo_id');
    }

    protected function consentUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => route('consent.show', ['token' => $this->token])
        );
    }
}
