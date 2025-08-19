<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use App\Application\Commands\CreateBlogCommand;
use App\Application\Commands\UpdateBlogCommand;
use App\Application\Commands\DeleteBlogCommand;
use App\Application\Queries\ListBlogsQuery;
use App\Application\Queries\ShowBlogQuery;
use App\Http\Requests\BlogRequest;
use App\Http\Resources\BlogResource;

class BlogController extends Controller
{
    public function __construct(protected CommandBus $commandBus, protected QueryBus $queryBus) {}

    public function index()
    {
        $blogs = $this->queryBus->dispatch(new ListBlogsQuery(request('user_id')));
        return BlogResource::collection($blogs);
    }

    public function store(BlogRequest $request)
    {
        $blog = $this->commandBus->dispatch(new CreateBlogCommand($request->validated()));
        return new BlogResource($blog);
    }

    public function show(int $id)
    {
        $blog = $this->queryBus->dispatch(new ShowBlogQuery($id));
        return new BlogResource($blog);
    }

    public function update(BlogRequest $request, int $id)
    {
        $blog = $this->commandBus->dispatch(new UpdateBlogCommand($id, $request->validated()));
        return new BlogResource($blog);
    }

    public function destroy(int $id)
    {
        $this->commandBus->dispatch(new DeleteBlogCommand($id));
        return response()->json(['message' => 'Blog deleted successfully']);
    }
}
