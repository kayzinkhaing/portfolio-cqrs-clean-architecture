<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// === Import your events and listeners ===
use App\Events\UserCreatedEvent;
use App\Listeners\UpdateUserReadModel;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        // When a user is created in MySQL, update the MongoDB read model
        UserCreatedEvent::class => [
            UpdateUserReadModel::class,
        ],

        // You can add more events here for CQRS
        // Example:
        // BlogCreatedEvent::class => [
        //     UpdateBlogReadModel::class,
        // ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        parent::boot();

        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        // Set to true if you want Laravel to auto-discover events in the Listeners directory
        return false;
    }
}
