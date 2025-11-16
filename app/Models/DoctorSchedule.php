<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorSchedule extends Model
{
    protected $fillable = [
        'doctor_id',
        'date',
        'hour',
        'status',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
