<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimelineItem;

class TimelineItemSeeder extends Seeder
{
    public function run()
    {
        TimelineItem::factory(10)->create();
    }
}
