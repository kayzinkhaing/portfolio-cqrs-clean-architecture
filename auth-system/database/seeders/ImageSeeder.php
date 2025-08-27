<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Image;
use App\Models\Project;
use App\Models\Skill;

class ImageSeeder extends Seeder
{
    public function run()
    {
        Project::all()->each(function ($project) {
            Image::factory(rand(1, 3))->create([
                'imageable_type' => Project::class,
                'imageable_id' => $project->id,
            ]);
        });

        Skill::all()->each(function ($skill) {
            Image::factory(1)->create([
                'imageable_type' => Skill::class,
                'imageable_id' => $skill->id,
            ]);
        });
    }
}
