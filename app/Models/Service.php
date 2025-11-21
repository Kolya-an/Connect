<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'price', 'header', 'footer'];

    protected function casts(): array
    {
        return [
            'header' => 'boolean',
            'footer' => 'boolean',
        ];
    }
    public function doctors()
    {
        //return $this->hasOne(Doctor::class);
        return $this->belongsToMany(Doctor::class, 'doctor_service')
            ->withPivot(['name', 'price', 'prefix']);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
