<?php
namespace App\Application\Handlers;

use App\Application\Commands\CreateBlogCommand;
use App\Services\BlogService;

class CreateBlogHandler
{
    protected BlogService $service;

    public function __construct(BlogService $service)
    {
        $this->service = $service;
    }

    public function handle(CreateBlogCommand $command)
    {
        return $this->service->createBlog($command->data);
    }
}
