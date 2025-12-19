<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DoctorPhoto extends Model
{
    //use HasFactory;
    protected $fillable = ['doctor_id', 'photo', 'procedure', 'product', 'list', 'photo_before', 'photo_after', 'orientation'];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
