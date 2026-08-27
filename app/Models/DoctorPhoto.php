<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DoctorPhoto extends Model
{
    //use HasFactory;
    protected $fillable = [
        'doctor_id', 
        'photo', 
        'procedure', 
        'product', 
        'list', 
        'photo_before', 
        'photo_after', 
        'orientation', 
        'patient_id',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function consent()
    {
        return $this->hasOne(PhotoConsent::class, 'doctor_photo_id');
    }

    public function photoConsent(): HasOne
    {
        return $this->hasOne(PhotoConsent::class, 'doctor_photo_id');
    }

    public function userSignature(): HasOne
    {
        return $this->hasOne(UserSignature::class, 'doctor_photo_id');
    }

   public function patient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pacient::class, 'patient_id');
    }
}
