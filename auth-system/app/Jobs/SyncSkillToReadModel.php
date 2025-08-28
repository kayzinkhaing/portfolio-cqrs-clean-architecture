<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Skill;
use MongoDB\Client;

class SyncSkillToReadModel implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    protected int $id;
    protected string $action;

    public function __construct(int $id, string $action = 'update')
    {
        $this->id = $id;
        $this->action = $action;
    }

    public function handle()
    {
        $skill = Skill::find($this->id);
        if (!$skill) return;

        $client = new Client('mongodb://mongo:27017'); // must match your .env
        $collection = $client->read_model->skills; // make sure 'skills' is lowercase

        $document = [
            '_id' => $skill->id,
            'skill_category_id' => $skill->skill_category_id,
            'name' => $skill->name,
            'level' => $skill->level,
            'icon' => $skill->icon,
            'created_at' => $skill->created_at,
            'updated_at' => $skill->updated_at,
        ];

        if ($this->action === 'update') {
            $collection->updateOne(
                ['_id' => $skill->id],
                ['$set' => $document],
                ['upsert' => true]
            );
        } elseif ($this->action === 'delete') {
            $collection->deleteOne(['_id' => $skill->id]);
        }
    }
}
