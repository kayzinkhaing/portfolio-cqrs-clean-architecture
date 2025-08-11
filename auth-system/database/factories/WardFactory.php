<?php

namespace Database\Factories;

use App\Models\Ward;
use App\Models\Township;
use Illuminate\Database\Eloquent\Factories\Factory;

class WardFactory extends Factory
{
    protected $model = Ward::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->streetName(),  
            'township_id' => Township::factory(), // will override in seeder anyway
        ];
    }
}
