<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TimelineItem;
class TimelineItemFactory extends Factory
{
    protected $model = TimelineItem::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'subtitle' => $this->faker->sentence(2),
            'description' => $this->faker->paragraph,
            'type' => $this->faker->randomElement(['education', 'work', 'project', 'other']),
            'year' => $this->faker->year,
        ];
    }
}
