<?php

namespace App\Application\Handlers;

use App\Application\Commands\UpdateBlogCommand;
use App\Services\BlogService;

class UpdateBlogHandler
{
    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function handle(UpdateBlogCommand $command)
    {
        return $this->blogService->updateBlog($command->blogId, $command->data);
    }
}
