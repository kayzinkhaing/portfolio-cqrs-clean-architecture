<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use App\Jobs\SyncUserToReadModel;

class SyncAllUsersCommand extends Command
{
    protected $signature = 'users:sync-all';
    protected $description = 'Sync all MySQL users to MongoDB read model';

    public function handle()
    {
        $this->info("Starting user sync...");

        User::chunk(100, function ($users) {
            foreach ($users as $user) {
                // Queue the job for each user
                SyncUserToReadModel::dispatch($user->id);
            }
        });

        $this->info("All users have been synced to MongoDB.");
        return 0;
    }
}
