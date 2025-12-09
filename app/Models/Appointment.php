<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Doctor;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'doctor_id',
        'date',
        'hour',
        'status',
        'cause',
        'information',
        'service_id'
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'hour' => 'string', // 'datetime' лучше для TimePicker в Filament
        'status' => 'string',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function patient()
    {
        return $this->belongsTo(Pacient::class);
    }
    public function pacient()    // фамилия пациента из таблицы pacients
    {
        return $this->hasOne(Pacient::class, 'user_id', 'user_id');
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
    public function review()
    {
        return $this->hasOne(Review::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function doctorUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

// Связь для получения фамилии доктора (из doctors.second_name)
    public function doctorInfo(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
    public function doctorProfile()
    {
        return $this->hasOne(Doctor::class,'user_id','doctor_id');
    }
}
