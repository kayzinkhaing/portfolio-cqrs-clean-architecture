<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Page;
use App\Jobs\SyncPageToReadModel;

class SyncAllPagesCommand extends Command
{
    protected $signature = 'pages:sync-all';
    protected $description = 'Sync all MySQL pages to MongoDB read model';

    public function handle()
    {
        $this->info("Starting pages sync...");

        Page::chunk(100, function ($pages) {
            foreach ($pages as $page) {
                SyncPageToReadModel::dispatch($page->id, 'update');
            }
        });

        $this->info("All pages have been synced to MongoDB.");
        return 0;
    }
}
