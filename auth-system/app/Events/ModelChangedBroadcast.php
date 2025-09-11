<?php

namespace App\Events;

use Illuminate\Support\Str;
use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ModelChangedBroadcast implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets;

    public string $model;
    public int $id;
    public string $action;
    public array $payload;
    // public $queue = 'domain-events';
    /**
     * Create a new event instance.
     */
    public function __construct(string $model, int $id, string $action, array $payload = [])
    {
        // Convert model class name (e.g. App\Models\ContactMessage)
        // → contact-message (safe for Pusher channel)
        $this->model = Str::kebab(class_basename($model));
        $this->id = $id;
        $this->action = $action;
        $this->payload = $payload;
    }

    /**
     * The channel the event should broadcast on.
     */
    public function broadcastOn()
    {
        // Example: model-changed-contact-message
        return new Channel("model-changed-{$this->model}");
    }

    /**
     * The event name (frontend listens to this).
     */
    public function broadcastAs()
    {
        return 'model.changed';
    }

    /**
     * Customize broadcast payload.
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->id,
            'model' => $this->model,
            'action' => $this->action,
            'payload' => $this->payload,
        ];
    }
}
