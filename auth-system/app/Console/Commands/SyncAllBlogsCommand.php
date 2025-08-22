<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Jobs\SyncBlogToReadModel;

class SyncAllBlogsCommand extends Command
{
    // Command signature (what you type in terminal)
    protected $signature = 'blogs:sync-all';

    // Description (shown in `php artisan list`)
    protected $description = 'Sync all MySQL blogs to MongoDB read model';

    public function handle()
    {
        $this->info("Starting blog sync...");

        // Run job synchronously
        $job = new SyncBlogToReadModel();
        $job->handle();

        $this->info("All blogs have been synced to MongoDB.");
        return 0;
    }
}
