<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Township;
use App\Jobs\SyncTownshipToReadModel;

class SyncAllTownshipsCommand extends Command
{
    protected $signature = 'townships:sync-all';
    protected $description = 'Sync all MySQL townships to MongoDB read model';

    public function handle()
    {
        $this->info("Starting township sync...");

        Township::chunk(100, function ($townships) {
            foreach ($townships as $township) {
                $job = new SyncTownshipToReadModel($township->id, 'update');
                $job->handle(); // synchronous run
            }
        });

        $this->info("All townships have been synced to MongoDB.");
        return 0;
    }
}
