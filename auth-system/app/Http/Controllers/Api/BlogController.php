<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Resources\BlogResource;
use App\Http\Requests\BlogRequest;

class BlogController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * List all blog records with optional filters and pagination.
     */
    public function index(Request $request)
    {
        $result = $this->queryBus->dispatch(
            new CrudQuery('Blog', 'list', $request->all())
        );

        return BlogResource::collection($result)->additional([
            'meta' => [
                'count' => count($result),
            ],
        ]);
    }

    /**
     * Store a new blog record.
     */
    public function store(BlogRequest $request)
    {
        $blog = $this->commandBus->dispatch(
            new CrudCommand('Blog', 'create', $request->validated())
        );

        return (new BlogResource($blog))
            ->response()
            ->setStatusCode(201); // REST: 201 Created
    }

    /**
     * Get a single blog record.
     */
    public function show(int $id)
    {
        $blog = $this->queryBus->dispatch(
            new CrudQuery('Blog', 'get', ['id' => $id])
        );

        return new BlogResource($blog);
    }

    /**
     * Update an existing blog record.
     */
    public function update(BlogRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $blog = $this->commandBus->dispatch(
            new CrudCommand('Blog', 'update', $payload)
        );

        return new BlogResource($blog);
    }

    /**
     * Delete a blog record.
     */
    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Blog', 'delete', ['id' => $id])
        );

        return response()->json(null, 204); // REST: No Content
    }
}
