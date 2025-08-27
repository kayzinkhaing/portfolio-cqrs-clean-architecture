<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\SkillCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillCategoryFactory extends Factory
{
    protected $model = SkillCategory::class;

    public function definition()
    {
        $categories = ['Frontend', 'Backend', 'Tools & Deployment'];
        $name = $this->faker->unique()->randomElement($categories);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
