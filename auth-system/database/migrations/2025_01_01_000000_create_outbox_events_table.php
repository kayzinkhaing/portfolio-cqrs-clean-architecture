<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('outbox_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('aggregate_type');     // e.g. "user"
            $table->string('event_type');         // e.g. "user.created"
            $table->unsignedBigInteger('aggregate_id');
            $table->json('payload');              // full event data
            $table->timestamp('occurred_at');
            $table->timestamp('published_at')->nullable(); // set when sent to Rabbit
            $table->unsignedInteger('publish_attempts')->default(0);
            $table->text('last_error')->nullable();
            $table->timestamps();

            $table->index(['published_at', 'event_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outbox_events');
    }
};

