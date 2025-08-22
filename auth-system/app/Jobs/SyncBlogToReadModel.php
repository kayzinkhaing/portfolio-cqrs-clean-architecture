<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Blog;
use MongoDB\Client as MongoClient;

class SyncBlogToReadModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $blogId;

    public function __construct(int $blogId)
    {
        $this->blogId = $blogId;
    }

    public function handle()
    {
        $mongo = new MongoClient('mongodb://mongo:27017');
        $db = $mongo->selectDatabase('read_model');
        $collection = $db->selectCollection('blogs');

        // Fetch only the single blog with user relations
        $blog = Blog::with(['user.township', 'user.ward'])->find($this->blogId);

        if (!$blog) {
            return; // Blog not found, nothing to sync
        }

        $collection->updateOne(
            ['id' => $blog->id],
            [
                '$set' => [
                    'id' => $blog->id,
                    'title' => $blog->title,
                    'excerpt' => $blog->excerpt,
                    'content' => $blog->content,
                    'published_at' => $blog->published_at ? (string) $blog->published_at : null,
                    'created_at'   => $blog->created_at ? (string) $blog->created_at : null,
                    'updated_at'   => $blog->updated_at ? (string) $blog->updated_at : null,

                    'user' => $blog->user ? [
                        'id' => $blog->user->id,
                        'name' => $blog->user->name,
                        'email' => $blog->user->email,
                        'township' => $blog->user->township ? [
                            'id' => $blog->user->township->id,
                            'name' => $blog->user->township->name,
                            'created_at' => (string) $blog->user->township->created_at,
                            'updated_at' => (string) $blog->user->township->updated_at,
                        ] : null,
                        'ward' => $blog->user->ward ? [
                            'id' => $blog->user->ward->id,
                            'name' => $blog->user->ward->name,
                            'township_id' => $blog->user->ward->township_id,
                            'created_at' => (string) $blog->user->ward->created_at,
                            'updated_at' => (string) $blog->user->ward->updated_at,
                        ] : null,
                        'created_at' => (string) $blog->user->created_at,
                        'updated_at' => (string) $blog->user->updated_at,
                    ] : null,
                ]
            ],
            ['upsert' => true]
        );
    }
}
