<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Township;

class TownshipSeeder extends Seeder
{
    public function run()
    {
        $townships = [
            'Dagon Seikkan',
            'Thingangyun',
            'Bahan',
            'Hlaing',
            'Mayangone',
            'Insein',
            'Sanchaung',
            'Kyimyindaing',
            'Tamwe',
            'South Okkalapa',
            'North Okkalapa',
            'Botahtaung',
            'Lanmadaw',
            'Pabedan'
        ];

        foreach ($townships as $name) {
            Township::create(['name' => $name]);
        }
    }
}
