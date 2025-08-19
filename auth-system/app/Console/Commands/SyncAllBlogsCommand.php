<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Blog;
use App\Models\BlogReadModel;

class SyncAllBlogsCommand extends Command
{
    protected $signature = 'blogs:sync-all {--chunk=500}';
    protected $description = 'Sync all MySQL blogs to MongoDB read model';

    public function handle()
    {
        $chunkSize = (int) $this->option('chunk');
        $this->info("Starting blog sync with chunk size: {$chunkSize}");

        Blog::chunk($chunkSize, function ($blogs) {
            foreach ($blogs as $blog) {
                BlogReadModel::updateOrCreate(
                    ['id' => $blog->id],
                    $blog->toArray()
                );
            }
        });

        $this->info("All blogs have been synced to MongoDB.");
        return 0;
    }
}
