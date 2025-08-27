<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Skill;
use App\Models\SkillCategory;

class SkillSeeder extends Seeder
{
    public function run()
    {
        $categories = SkillCategory::all();

        foreach ($categories as $category) {
            Skill::factory(5)->create([
                'skill_category_id' => $category->id,
            ]);
        }
    }
}
