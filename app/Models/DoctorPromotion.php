<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorPromotion extends Model
{
    //use HasFactory;
    protected $fillable = [
        'doctor_id', 'title', 'description',
        'old_price', 'new_price',
        'date_from', 'date_to', 'map',
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date',
        'map' => 'boolean',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
