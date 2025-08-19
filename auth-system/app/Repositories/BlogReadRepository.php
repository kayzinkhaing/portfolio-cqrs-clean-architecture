<?php

namespace App\Repositories;

use App\Contracts\BlogReadRepositoryInterface;
use App\Models\BlogReadModel;

class BlogReadRepository extends BaseReadRepository implements BlogReadRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new BlogReadModel());
    }

    public function getByUser(int $userId)
    {
        return $this->getAll(['user_id' => $userId]);
    }
}
