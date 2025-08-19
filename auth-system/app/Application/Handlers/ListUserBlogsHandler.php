<?php

namespace App\Application\Handlers;

use App\Application\Queries\ListUserBlogsQuery;
use App\Services\BlogService;

class ListUserBlogsHandler
{
    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function handle(ListUserBlogsQuery $query)
    {
        return $this->blogService->listUserBlogs($query->userId);
    }
}
