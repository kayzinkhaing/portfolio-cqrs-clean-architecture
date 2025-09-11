<?php

namespace App\Http\Controllers\Api;

use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;
    }

    /**
     * List all projects with optional filters.
     */
    public function index(Request $request)
    {
        $projects = $this->queryBus->dispatch(
            new CrudQuery('Project', 'list', $request->all())
        );

        $projects->loadMissing(['technologies', 'status']);

        return ProjectResource::collection($projects);
    }

    /**
     * Store a new project.
     */
    public function store(StoreProjectRequest $request)
    {
        $project = $this->commandBus->dispatch(
            new CrudCommand('Project', 'create', $request->validated())
        );

        return new ProjectResource($project);
    }

    /**
     * Show a single project by ID.
     */
    public function show(int $id)
    {
        $project = $this->queryBus->dispatch(
            new CrudQuery('Project', 'get', ['id' => $id])
        );

        if (! $project) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found'
            ], 404);
        }

        $project->loadMissing(['technologies', 'status']);

        return new ProjectResource($project);
    }

    /**
     * Update an existing project.
     */
    public function update(UpdateProjectRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $project = $this->commandBus->dispatch(
            new CrudCommand('Project', 'update', $payload)
        );

        return new ProjectResource($project);
    }

    /**
     * Delete a project.
     */
    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Project', 'delete', ['id' => $id])
        );

        return response()->json(null, 204); // RESTful "No Content"
    }
}
