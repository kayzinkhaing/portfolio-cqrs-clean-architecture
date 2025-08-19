<?php

namespace App\Services;

use App\Contracts\BlogRepositoryInterface;
use App\Contracts\BlogReadRepositoryInterface;
use App\Jobs\SyncBlogToReadModel;
use Illuminate\Support\Facades\Auth;
use App\Models\Blog;

class BlogService
{
    protected BlogRepositoryInterface $blogRepo;
    protected BlogReadRepositoryInterface $readRepo;

    public function __construct(
        BlogRepositoryInterface $blogRepo,
        BlogReadRepositoryInterface $readRepo
    ) {
        $this->blogRepo = $blogRepo;
        $this->readRepo = $readRepo;
    }

    // ------------------
    // READ (Mongo)
    // ------------------
    public function listBlogs(?int $userId = null)
    {
        return $userId
            ? $this->readRepo->getByUser($userId)
            : $this->readRepo->getAll();
    }

    public function listUserBlogs(int $userId)
    {
        return $this->readRepo->getByUser($userId);
    }

    public function showBlog(int $blogId)
    {
        return $this->readRepo->findById($blogId);
    }

    // ------------------
    // WRITE (MySQL + async Mongo sync)
    // ------------------
    public function createBlog(array $data): Blog
    {
        $data['user_id'] = Auth::id();
        $blog = $this->blogRepo->create($data);
        SyncBlogToReadModel::dispatch($blog->id); // async update Mongo
        return $blog;
    }

    public function updateBlog(int $blogId, array $data): Blog
    {
        $blog = $this->blogRepo->update($blogId, $data);
        SyncBlogToReadModel::dispatch($blog->id); // async update Mongo
        return $blog;
    }

    public function deleteBlog(int $blogId): void
    {
        $this->blogRepo->delete($blogId);
        $this->readRepo->delete($blogId);
    }
}
