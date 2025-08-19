<?php

namespace App\Application\Handlers;

use App\Application\Queries\ShowBlogQuery;
use App\Services\BlogService;

class ShowBlogHandler
{
    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function handle(ShowBlogQuery $query)
    {
        return $this->blogService->showBlog($query->blogId);
    }
}
