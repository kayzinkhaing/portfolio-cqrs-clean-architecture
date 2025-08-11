<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ward;
use App\Models\Township;

class WardSeeder extends Seeder
{
    public function run()
    {
        $townships = Township::all();

        foreach ($townships as $township) {
            // Create 5 wards for each township
            for ($i = 1; $i <= 5; $i++) {
                Ward::create([
                    'name' => "Ward $i of " . $township->name,
                    'township_id' => $township->id,
                ]);
            }
        }
    }
}
