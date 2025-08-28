<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Education;
use App\Jobs\SyncEducationToReadModel;

class SyncAllEducationsCommand extends Command
{
    protected $signature = 'educations:sync-all';
    protected $description = 'Sync all MySQL educations to MongoDB read model';

    public function handle()
    {
        $this->info("Starting educations sync...");

        Education::chunk(100, function ($educations) {
            foreach ($educations as $education) {
                SyncEducationToReadModel::dispatch($education->id, 'update');
            }
        });

        $this->info("All educations have been synced to MongoDB.");
        return 0;
    }
}
