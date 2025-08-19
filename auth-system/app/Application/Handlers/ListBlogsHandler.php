<?php

namespace App\Application\Handlers;

use App\Application\Queries\ListBlogsQuery;
use App\Services\BlogService;

class ListBlogsHandler
{
    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function handle(ListBlogsQuery $query)
    {
        return $this->blogService->listBlogs($query->userId ?? null);
    }
}
