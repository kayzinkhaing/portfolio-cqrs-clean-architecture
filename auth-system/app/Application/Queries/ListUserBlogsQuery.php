<?php
namespace App\Application\Queries;

class ListUserBlogsQuery
{
    public int $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }
}
