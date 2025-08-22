<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Ward;
use App\Jobs\SyncWardToReadModel;

class SyncAllWardsCommand extends Command
{
    protected $signature = 'wards:sync-all';
    protected $description = 'Sync all MySQL wards to MongoDB read model';

    public function handle()
    {
        $this->info("Starting ward sync...");

        Ward::chunk(100, function ($wards) {
            foreach ($wards as $ward) {
                $job = new SyncWardToReadModel($ward->id, 'update');
                $job->handle(); // synchronous run
            }
        });

        $this->info("All wards have been synced to MongoDB.");
        return 0;
    }
}
