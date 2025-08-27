<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Townships first
        $this->call(TownshipSeeder::class);

        // 2. Seed Wards after townships
        $this->call(WardSeeder::class);

        // 3. Seed 10,000 Users after wards and townships exist
        $this->call(UserSeeder::class);
        $this->call(BlogSeeder::class);

        // 4. Create a test user for blogs
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            StatusSeeder::class,
            TechnologySeeder::class,
            SkillCategorySeeder::class,
            SkillSeeder::class,
            ProjectSeeder::class,
            EducationSeeder::class,
            ExperienceSeeder::class,
            TimelineItemSeeder::class,
            ContactMessageSeeder::class,
            TestimonialSeeder::class,
            PageSeeder::class,
            SettingSeeder::class,
            // ImageSeeder is optional if already attached in ProjectSeeder
        ]);

    }
}
