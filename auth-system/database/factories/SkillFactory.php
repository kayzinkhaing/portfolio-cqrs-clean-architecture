<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\SkillCategory;
use App\Models\Skill;
class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'level' => $this->faker->numberBetween(50, 100),
            'skill_category_id' => SkillCategory::inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
