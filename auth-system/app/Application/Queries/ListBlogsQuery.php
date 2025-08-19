<?php
namespace App\Application\Queries;

class ListBlogsQuery
{
    public ?int $userId;

    public function __construct(?int $userId = null)
    {
        $this->userId = $userId;
    }
}
