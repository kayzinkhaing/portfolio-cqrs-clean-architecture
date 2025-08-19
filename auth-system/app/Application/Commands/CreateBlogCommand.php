<?php
namespace App\Application\Commands;

class CreateBlogCommand
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
