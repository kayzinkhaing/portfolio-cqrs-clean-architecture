<?php

namespace Database\Factories;

use App\Models\Township;
use Illuminate\Database\Eloquent\Factories\Factory;

class TownshipFactory extends Factory
{
    protected $model = Township::class;

    public function definition()
    {
        return [
            // You can list Myanmar townships here manually or generate fake names
            'name' => $this->faker->unique()->city(), // or provide actual list
        ];
    }
}
