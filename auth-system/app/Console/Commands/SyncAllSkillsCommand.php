<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Skill;
use App\Jobs\SyncSkillToReadModel;

class SyncAllSkillsCommand extends Command
{
    protected $signature = 'skills:sync-all';
    protected $description = 'Sync all MySQL skills to MongoDB read model';

    public function handle()
    {
        $this->info("Starting skills sync...");

        Skill::chunk(100, function ($skills) {
            foreach ($skills as $skill) {
                SyncSkillToReadModel::dispatch($skill->id, 'update'); // synchronous or queued
            }
        });

        $this->info("All skills have been synced to MongoDB.");
        return 0;
    }
}
