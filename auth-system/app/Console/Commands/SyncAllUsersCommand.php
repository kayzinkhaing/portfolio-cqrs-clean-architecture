<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SyncUserToReadModel;

class SyncAllUsersCommand extends Command
{
    protected $signature = 'users:sync-all';
    protected $description = 'Sync all MySQL users to MongoDB read model';

    public function handle()
    {
        $this->info("Starting user sync...");

        // Run job synchronously
        $job = new SyncUserToReadModel();
        $job->handle();

        $this->info("All users have been synced to MongoDB.");
        return 0;
    }
}
