<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Image;
class ImageFactory extends Factory
{
    protected $model = Image::class;

    public function definition()
    {
        return [
            'path' => $this->faker->imageUrl(640, 480, 'portfolio', true),
            'imageable_type' => \App\Models\Project::class, // can be dynamic in seeder
            'imageable_id' => 1, // will override in seeder
            'is_primary' => $this->faker->boolean(30),
        ];
    }
}
