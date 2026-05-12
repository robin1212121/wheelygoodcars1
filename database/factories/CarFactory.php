<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Car;
use App\Models\User;

class CarFactory extends Factory
{
    protected $model = Car::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),

            'license_plate' => strtoupper(fake()->bothify('??-###-?')),
            'brand' => fake()->randomElement(['BMW', 'Audi', 'Toyota']),
            'model' => fake()->word(),
            'price' => fake()->numberBetween(1000, 30000),

            'mileage' => fake()->numberBetween(10000, 200000),
            'production_year' => fake()->numberBetween(2000, 2024),

            'color' => fake()->safeColorName(),
        ];
    }
}