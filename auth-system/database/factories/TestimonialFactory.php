<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Testimonial;

class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'position' => $this->faker->jobTitle,
            'company' => $this->faker->company,
            'testimonial' => $this->faker->paragraph,
            'is_active' => $this->faker->boolean(90), // 90% chance true
        ];
    }
}
