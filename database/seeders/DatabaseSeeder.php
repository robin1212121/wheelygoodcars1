<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Car;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
      
        $users = User::factory(150)->create();

     
        Car::factory(250)->create()->each(function ($car) use ($users) {

            $car->user_id = $users->random()->id;
            $car->save();
        });
    }
}