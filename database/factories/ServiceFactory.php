<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Service;


class ServiceFactory extends Factory
{

    protected $model = Service::class;
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
        ];
    }
}
