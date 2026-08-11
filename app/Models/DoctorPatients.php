<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorPatients extends Model
{
    protected $fillable = [
        'user_id',
        'doctor_id',
        'text',
        'doctor_rel',
    ];
    protected $casts = [
        'doctor_rel' => 'date:Y-m-d',
        'text' => 'encrypted',
    ];
}
