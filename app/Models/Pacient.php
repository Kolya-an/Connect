<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
}
