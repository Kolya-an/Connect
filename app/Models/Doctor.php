<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Services\GeocodingService;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'types',
        'location',
        'sex',
        'education_images',
        'extra_images',
        'plate',
        'active',
        'rating',
        'at_home',
        'gift',
        'share',
        'latitude',
        'longitude'
    ];

    protected function casts(): array
    {
        return [
            'types' => 'array',
            'education_images' => 'array',
            'extra_images' => 'array',
        ];
    }
    protected static function booted()
    {
        static::saving(function (Doctor $doctor) {
            if ($doctor->isDirty('city') || $doctor->isDirty('address')) {
                $full = trim($doctor->address . ', ' . $doctor->city);
                $coords = GeocodingService::geocode($full);

                if ($coords) {
                    $doctor->latitude = $coords['lat'];
                    $doctor->longitude = $coords['lng'];
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function education()
    {
        return $this->hasOne(Education::class);
    }
    public function educations()
    {
        // Один врач имеет МНОГО записей в таблице education
        return $this->hasMany(Education::class);
    }
    public function extra()
    {
        return $this->hasOne(Extra::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class, 'doctor_service')
            ->withPivot(['price', 'prefix']);

    }
    public function photos()
    {
        return $this->hasMany(DoctorPhoto::class);
    }
    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }
    public function promotions()
    {
        return $this->hasMany(DoctorPromotion::class);
    }

    /**
     * Отримати всіх унікальних пацієнтів через записа
     */
    public function patients()
    {
        return $this->belongsToMany(Pacient::class, 'appointments', 'doctor_id', 'user_id')
            ->withPivot('id');
    }

    public function reviews()
    {
        return $this->hasManyThrough(
            Review::class,    // Финальная модель (Отзывы)
            Appointment::class, // Промежуточная модель (Записи)
            'doctor_id',                  // appointments.doctor_id (связывает appointments с Doctor)
            'appointment_id',             // reviews.appointment_id (связывает reviews с Appointment)
            'id',                         // doctor.id (локальный ключ)
            'id'
        );
    }
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
    public function getFullNameAttribute(): string
    {
        return $this->user->name . ' ' . $this->second_name;
    }

}
