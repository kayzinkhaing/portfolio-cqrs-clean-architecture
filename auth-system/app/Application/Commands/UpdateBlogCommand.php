<?php
namespace App\Application\Commands;

class UpdateBlogCommand
{
    public int $blogId;
    public array $data;

    public function __construct(int $blogId, array $data)
    {
        $this->blogId = $blogId;
        $this->data = $data;
    }
}
