<?php

namespace App\Repositories;

use App\Contracts\BlogRepositoryInterface;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{
    public function __construct()
    {
        parent::__construct('Blog'); // dynamic binding to App\Models\Blog
    }
    public function getByUser(int $userId)
    {
        return $this->currentModel->where('user_id', $userId)->get();
    }
}
