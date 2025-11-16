<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'doctor_id',
        'date',
        'hour',
        'status',
        'cause',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
