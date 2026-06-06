<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Car;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔹 1. USERS (150 stuks)
        $users = User::factory(150)->create();

        // 🔹 2. TAGS (20 stuks voor B4)
        $tags = collect([
            'SUV',
            'Diesel',
            'Benzine',
            'Elektrisch',
            'Automaat',
            'Handgeschakeld',
            'Sport',
            'Luxe',
            '4x4',
            'Hybride',
            'Compact',
            'Stationwagen',
            'Cabrio',
            'Sedan',
            'Youngtimer',
            'Nieuw',
            'Zuinig',
            'Snelle auto',
            'Familieauto',
            'Zuinige motor'
        ])->map(fn ($name) => Tag::create(['name' => $name]));

        Car::factory(250)->create()->each(function ($car) use ($users, $tags) {

            $car->user_id = $users->random()->id;
            $car->save();

            $car->tags()->attach(
                $tags->random(rand(1, 4))->pluck('id')->toArray()
            );
        });
    }
}