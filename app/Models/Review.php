<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'appointment_id',
        'text',
        'medical',
        'service',
        'active'
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

}
