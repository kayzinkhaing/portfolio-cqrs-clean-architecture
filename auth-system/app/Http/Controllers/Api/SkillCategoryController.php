<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Resources\SkillCategoryResource;
use App\Http\Requests\StoreSkillCategoryRequest;
use App\Http\Requests\UpdateSkillCategoryRequest;

class SkillCategoryController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;
    }

    /**
     * List all skill categories.
     */
    public function index(Request $request)
    {
        $categories = $this->queryBus->dispatch(
            new CrudQuery('SkillCategory', 'list', $request->all())
        );

        return SkillCategoryResource::collection($categories)->additional([
            'meta' => [
                'count' => count($categories),
            ],
        ]);
    }

    /**
     * Store a new skill category.
     */
    public function store(StoreSkillCategoryRequest $request)
    {
        $category = $this->commandBus->dispatch(
            new CrudCommand('SkillCategory', 'create', $request->validated())
        );

        return (new SkillCategoryResource($category))->response()->setStatusCode(201);
    }

    /**
     * Get a single skill category.
     */
    public function show(int $id)
    {
        $category = $this->queryBus->dispatch(
            new CrudQuery('SkillCategory', 'get', ['id' => $id])
        );

        return new SkillCategoryResource($category);
    }

    /**
     * Update a skill category.
     */
    public function update(UpdateSkillCategoryRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $category = $this->commandBus->dispatch(
            new CrudCommand('SkillCategory', 'update', $payload)
        );

        return new SkillCategoryResource($category);
    }

    /**
     * Delete a skill category.
     */
    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('SkillCategory', 'delete', ['id' => $id])
        );

        return response()->json(null, 204);
    }
}
