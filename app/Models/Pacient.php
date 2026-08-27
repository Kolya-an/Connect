<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pacient extends Model
{
    //use HasFactory;
    protected $fillable = [
        'second_name',
        'birthday',
        'photo',
        'phone',
        'city',
        'address',
        'user_id',
        'notification',
        'sex',
        'name',
        'email',
        'password',
        'latitude',
        'longitude',
        'patient_history_agree',
        'agree',
        'patient_id',
    ];

    protected function casts(): array
    {
        return [
            'agree' => 'date:Y-m-d',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function patient(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Pacient::class, 'patient_id');
    }

    public function appointments(): HasMany
    {
        // Переконайтеся, що назва зовнішнього ключа (pacient_id або patient_id) відповідає вашій БД
        return $this->hasMany(Appointment::class, 'user_id');
    }
}
