<?php

namespace App\Application\Handlers;

use App\Application\Commands\DeleteBlogCommand;
use App\Services\BlogService;

class DeleteBlogHandler
{
    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function handle(DeleteBlogCommand $command)
    {
        return $this->blogService->deleteBlog($command->blogId);
    }
}
