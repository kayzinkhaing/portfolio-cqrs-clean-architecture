<?php

namespace App\Services;

use App\Repositories\BlogRepository;
use Illuminate\Support\Facades\Auth;

class BlogService
{
    protected BlogRepository $blogRepo;

    public function __construct(BlogRepository $blogRepo)
    {
        $this->blogRepo = $blogRepo;
    }

    public function listBlogs(?int $userId = null)
    {
        return $this->blogRepo->getAllWithUser($userId);
    }

    public function listUserBlogs($userId)
    {
        return $this->blogRepo->getByUser($userId);
    }

    public function createBlog(array $data)
    {
        $data['user_id'] = Auth::id();
        return $this->blogRepo->create($data);
    }

    public function updateBlog($blogId, array $data)
    {
        return $this->blogRepo->update($blogId, $data);
    }

    public function deleteBlog($blogId)
    {
        return $this->blogRepo->delete($blogId);
    }

    public function showBlog($blogId)
    {
        return $this->blogRepo->findById($blogId, ['user']);
    }
}
