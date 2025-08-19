<?php
namespace App\Application\Queries;

class ShowBlogQuery
{
    public int $blogId;

    public function __construct(int $blogId)
    {
        $this->blogId = $blogId;
    }
}
