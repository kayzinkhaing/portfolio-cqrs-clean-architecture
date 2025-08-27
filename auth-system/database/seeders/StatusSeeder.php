<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusSeeder extends Seeder
{
    public function run()
    {
        Status::factory()->createMany([
            ['name' => 'Finished', 'slug' => 'finished'],
            ['name' => 'In Progress', 'slug' => 'in-progress'],
        ]);
    }
}
