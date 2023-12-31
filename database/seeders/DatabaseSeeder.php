<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Zone;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         User::factory()->create([
             'name' => 'Mohamed Mostafa',
             'email' => 'ramyalfe22@gmail.com',
         ]);

        Zone::create(['name' => 'Green Zone', 'price_per_hour' => 100]);
        Zone::create(['name' => 'Yellow Zone', 'price_per_hour' => 200]);
        Zone::create(['name' => 'Red Zone', 'price_per_hour' => 300]);
    }
}
