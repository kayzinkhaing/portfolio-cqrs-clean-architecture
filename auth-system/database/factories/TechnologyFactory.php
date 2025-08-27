<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Technology;
class TechnologyFactory extends Factory
{
    protected $model = Technology::class;

    public function definition()
    {
        $techs = ['HTML', 'CSS', 'JavaScript', 'Vue.js', 'Laravel', 'PHP', 'MySQL', 'Docker', 'Tailwind', 'Bootstrap'];
        return [
            'name' => $this->faker->unique()->randomElement($techs),
            'slug' => $this->faker->unique()->slug(),
            'icon' => $this->faker->imageUrl(50, 50, 'tech', true),
        ];
    }
}
