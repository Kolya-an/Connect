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
        'education_images',
        'extra_images',
    ];

    protected function casts(): array
    {
        return [
            'services' => 'array',
            'education_images' => 'array',
            'extra_images' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function education()
    {
        return $this->hasOne(Education::class);
    }
    public function extra()
    {
        return $this->hasOne(Extra::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class)
            ->withPivot(['price', 'prefix'])
            ->withTimestamps();
    }

    public function photos()
    {
        return $this->hasMany(DoctorPhoto::class);
    }

}
