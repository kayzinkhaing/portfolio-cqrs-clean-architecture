<?php

namespace App\Listeners;

use App\Events\BlogCreatedEvent;
use App\Models\BlogReadModel;
use MongoDB\Client;

class UpdateBlogReadModel
{
    public function handle(BlogCreatedEvent $event)
    {
        $blog = $event->blog;

        BlogReadModel::insertOne(
            ['id' => $blog->id],
            [
                'user_id'     => $blog->user_id,
                'title'       => $blog->title,
                'excerpt'     => $blog->excerpt,
                'content'     => $blog->content,
                'published_at'=> $blog->published_at,
                'created_at'  => $blog->created_at,
                'updated_at'  => $blog->updated_at,
            ]
        );
    }
}
