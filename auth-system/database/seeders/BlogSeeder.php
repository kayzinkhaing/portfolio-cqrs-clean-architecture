<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = \App\Models\User::pluck('id')->toArray();

        Blog::factory()
            ->count(1000)
            ->create([
                'user_id' => fn() => fake()->randomElement($userIds),
            ]);
    }
}
