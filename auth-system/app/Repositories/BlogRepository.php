<?php

namespace App\Repositories;

use App\Contracts\BaseInterface;
use App\Models\Blog;

class BlogRepository extends BaseRepository implements BaseInterface
{
    public function __construct()
    {
        parent::__construct('Blog');
    }

    public function getAllWithUser(?int $userId = null)
    {
        return $this->currentModel
                    ->when($userId, fn($query) => $query->where('user_id', $userId))
                    ->with('user:id,name')
                    ->latest()
                    ->cursorPaginate(10);
    }

    public function getByUser($userId)
    {
        return $this->currentModel
                    ->where('user_id', $userId)
                    ->latest()
                    ->cursorPaginate(10);
    }
}
