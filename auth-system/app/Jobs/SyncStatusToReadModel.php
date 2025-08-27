<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable; // <-- add this
use App\Services\RabbitPublisher;
use App\Models\Status;

class SyncStatusToReadModel implements ShouldQueue
{
    use Dispatchable, Queueable, InteractsWithQueue, SerializesModels;

    protected int $id;
    protected string $action;

    public function __construct(int $id, string $action = 'sync')
    {
        $this->id = $id;
        $this->action = $action;
    }

    public function handle()
    {
        $status = Status::find($this->id);

        $payload = [
            'event' => 'status.' . ($this->action === 'deleted' ? 'deleted' : 'upsert'),
            'data' => $status ? $status->toArray() : ['id' => $this->id],
            'meta' => ['source' => 'write-api', 'action' => $this->action],
        ];

        if (class_exists(RabbitPublisher::class)) {
            $publisher = app(RabbitPublisher::class);
            $publisher->publish($payload['event'], $payload);
            return;
        }
    }
}
