<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    //use HasFactory;

    protected $fillable = ['doctor_id', 'title', 'period', 'desc'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
