<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Townships first
        $this->call(\Database\Seeders\TownshipSeeder::class);

        // 2. Seed Wards after townships
        $this->call(\Database\Seeders\WardSeeder::class);

        // 3. Seed 10,000 Users after wards and townships exist
        $this->call(\Database\Seeders\UserSeeder::class);
        $this->call(\Database\Seeders\BlogSeeder::class);

        // 4. Create a test user for blogs 
        $user = \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

    }
}
