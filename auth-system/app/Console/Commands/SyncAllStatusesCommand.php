<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Status;
use App\Jobs\SyncToReadModelJob;

class SyncAllStatusesCommand extends Command
{
    protected $signature = 'statuses:sync-all';
    protected $description = 'Sync all MySQL statuses to MongoDB read model';

    public function handle()
    {
        $this->info("Starting status sync...");

        Status::chunk(100, function ($statuses) {
            foreach ($statuses as $status) {
                SyncToReadModelJob::dispatch(Status::class, $status->id, 'update');
            }
        });

        $this->info("All statuses have been synced to MongoDB.");
        return 0;
    }
}
