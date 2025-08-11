<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    // Specify the model that this factory is for
    protected $model = Blog::class;

    // Define the model's default state.
    public function definition()
{
    return [
        'title' => $this->faker->sentence(),
        'excerpt' => $this->faker->paragraph(),
        'content' => $this->faker->paragraphs(3, true),
        'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
    ];
}

}
