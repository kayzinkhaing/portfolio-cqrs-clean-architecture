<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Experience;
class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    public function definition()
    {
        return [
            // 'user_id' => 1, // set a valid user id or use User factory
            'position' => $this->faker->jobTitle,
            'company' => $this->faker->company,
            'location' => $this->faker->city,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'responsibilities' => $this->faker->sentence(10),
        ];
    }
}
