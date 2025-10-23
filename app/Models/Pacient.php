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
        'user_id',
        'notification',
        'sex',
        'name',
        'email',
        'password',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
