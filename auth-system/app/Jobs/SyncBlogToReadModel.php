<?php

namespace App\Jobs;

use App\Models\BlogReadModel;
use App\Repositories\BlogRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SyncBlogToReadModel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $blogId;

    public $tries = 3;
    public $timeout = 120;

    public function __construct(int $blogId)
    {
        $this->blogId = $blogId;
    }

    public function handle(BlogRepository $repo)
    {
        $blog = $repo->findById($this->blogId);

        if (!$blog) return;

        BlogReadModel::updateOrCreate(
            ['id' => $blog->id],
            $blog->toArray()
        );
    }
}
