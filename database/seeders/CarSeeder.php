<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\User;
use App\Models\Tag;

class CarSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        if (!$user) {
            $user = User::factory()->create();
        }

        $tags = Tag::all();

        if ($tags->isEmpty()) {
            $tags = collect([
                Tag::create(['name' => 'SUV']),
                Tag::create(['name' => 'Diesel']),
                Tag::create(['name' => 'Automaat']),
            ]);
        }

        $car1 = Car::create([
            'license_plate' => 'AA-111-B',
            'brand' => 'BMW',
            'model' => 'X5',
            'price' => 25000,
            'user_id' => $user->id
        ]);

        $car2 = Car::create([
            'license_plate' => 'BB-222-C',
            'brand' => 'Audi',
            'model' => 'A3',
            'price' => 18000,
            'user_id' => $user->id
        ]);

       
        $car1->tags()->attach($tags->random(2)->pluck('id'));
        $car2->tags()->attach($tags->random(2)->pluck('id'));
    }
}