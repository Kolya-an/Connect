<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        return [
            'second_name' => $this->faker->name(),
            'birthday' => Carbon::now(),
            'photo' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
            'city' => $this->faker->city(),
            'experience' => $this->faker->randomNumber(),
            'address' => $this->faker->address(),
            'area' => $this->faker->word(),
            'desc' => $this->faker->word(),
            'services' => $this->faker->words(),
            'location' => $this->faker->words(),
            'sex' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
        ];
    }
}
