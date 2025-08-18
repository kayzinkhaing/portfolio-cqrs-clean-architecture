<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;
use App\Services\BlogService;
use Illuminate\Support\Facades\Gate;

class BlogController extends Controller
{
    protected BlogService $blogService;

    public function __construct(BlogService $blogService)
    {
        $this->blogService = $blogService;
    }

    public function index()
    {
        $blogs = $this->blogService->listBlogs(request('user_id'));
        return BlogResource::collection($blogs);
    }

    public function userBlogs($userId)
    {
        $blogs = $this->blogService->listUserBlogs($userId);
        return BlogResource::collection($blogs);
    }

    public function store(BlogRequest $request)
    {
        $blog = $this->blogService->createBlog($request->validated());
        return new BlogResource($blog);
    }

    public function show($id)
    {
        $blog = $this->blogService->showBlog($id);
        return new BlogResource($blog);
    }

    public function update(BlogRequest $request, $id)
    {
        $blog = $this->blogService->showBlog($id);

        if (!Gate::allows('update', $blog)) {
            abort(403, 'Unauthorized');
        }

        $updatedBlog = $this->blogService->updateBlog($id, $request->validated());
        return new BlogResource($updatedBlog);
    }

    public function destroy($id)
    {
        $blog = $this->blogService->showBlog($id);

        if (!Gate::allows('delete', $blog)) {
            abort(403, 'Unauthorized');
        }

        $this->blogService->deleteBlog($id);
        return response()->json(['message' => 'Blog deleted successfully.']);
    }
}
