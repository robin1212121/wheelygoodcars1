<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\User;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $user = User::factory()->create();
        }

        Car::create([
            'license_plate' => 'AA-111-B',
            'brand' => 'BMW',
            'model' => 'X5',
            'price' => 25000,
            'user_id' => $user->id
        ]);

        Car::create([
            'license_plate' => 'BB-222-C',
            'brand' => 'Audi',
            'model' => 'A3',
            'price' => 18000,
            'user_id' => $user->id
        ]);
    }
}