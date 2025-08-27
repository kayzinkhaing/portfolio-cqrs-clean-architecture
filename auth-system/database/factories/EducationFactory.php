<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Education;

class EducationFactory extends Factory
{
    protected $model = Education::class;

    public function definition()
    {
        return [
            // 'user_id' => 1, // or use User factory if you have one
            'institution' => $this->faker->company,
            'degree' => $this->faker->jobTitle,
            // 'field' => $this->faker->word,
            'location' => $this->faker->city,
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            // 'is_current' => $this->faker->boolean,
            'details' => $this->faker->sentence,
            // 'order' => $this->faker->numberBetween(1, 10),
        ];
    }
}
