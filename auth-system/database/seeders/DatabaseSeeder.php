<?php

namespace Database\Seeders;

use App\Models\Blog;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
        {
            $user = \App\Models\User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

            \App\Models\Blog::factory(10)->create([
                'user_id' => $user->id,  // assign this existing user id dynamically
            ]);
        }

}
