<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Status;
use App\Models\Project;


class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition()
    {
        $title = $this->faker->sentence(3);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph,
            'status_id' => Status::inRandomOrder()->first()?->id ?? 1,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'is_featured' => $this->faker->boolean(20),
        ];
    }
}
