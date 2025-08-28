<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Experience;
use App\Jobs\SyncExperienceToReadModel;

class SyncAllExperiencesCommand extends Command
{
    protected $signature = 'experiences:sync-all';
    protected $description = 'Sync all MySQL experiences to MongoDB read model';

    public function handle()
    {
        $this->info("Starting experiences sync...");

        Experience::chunk(100, function ($experiences) {
            foreach ($experiences as $experience) {
                SyncExperienceToReadModel::dispatch($experience->id, 'update');
            }
        });

        $this->info("All experiences have been synced to MongoDB.");
        return 0;
    }
}
