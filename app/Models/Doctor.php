<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'second_name',
        'birthday',
        'photo',
        'phone',
        'city',
        'user_id',
        'experience',
        'address',
        'area',
        'desc',
        'services',
        'location',
        'sex',


    ];

    protected function casts(): array
    {
        return [
            'services' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
