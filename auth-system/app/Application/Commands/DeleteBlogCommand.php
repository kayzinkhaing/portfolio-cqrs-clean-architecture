<?php
namespace App\Application\Commands;

class DeleteBlogCommand
{
    public int $blogId;

    public function __construct(int $blogId)
    {
        $this->blogId = $blogId;
    }
}
