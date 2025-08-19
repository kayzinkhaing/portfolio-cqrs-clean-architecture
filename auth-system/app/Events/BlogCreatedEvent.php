<?php

namespace App\Events;

use App\Models\Blog;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BlogCreatedEvent
{
    use Dispatchable, SerializesModels;

    public Blog $blog;

    public function __construct(Blog $blog)
    {
        $this->blog = $blog;
    }
}
