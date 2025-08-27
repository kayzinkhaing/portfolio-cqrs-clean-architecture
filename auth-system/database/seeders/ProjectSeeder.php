<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Image;
use App\Models\Status;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $technologies = Technology::all();
        $statuses = Status::all();

        Project::factory(10)->create()->each(function ($project) use ($technologies, $statuses) {
            // attach random technologies (pivot)
            $project->technologies()->attach(
                $technologies->random(rand(2, 5))->pluck('id')->toArray()
            );

            // assign status randomly
            $project->status_id = $statuses->random()->id;
            $project->save();

            // create polymorphic images
            Image::factory(rand(1, 3))->create([
                'imageable_type' => Project::class,
                'imageable_id' => $project->id,
            ]);
        });
    }
}
