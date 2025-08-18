<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OutboxEvent extends Model
{
    use HasUuids;

    protected $table = 'outbox_events';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id', 'aggregate_type', 'event_type', 'aggregate_id',
        'payload', 'occurred_at', 'published_at', 'publish_attempts', 'last_error'
    ];

    protected $casts = [
        'payload' => 'array',
        'occurred_at' => 'datetime',
        'published_at' => 'datetime',
    ];
}
