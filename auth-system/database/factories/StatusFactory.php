<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Status;
class StatusFactory extends Factory
{
    protected $model = Status::class;

    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(['Finished', 'In Progress']),
            'slug' => $this->faker->slug(),
        ];
    }
}
