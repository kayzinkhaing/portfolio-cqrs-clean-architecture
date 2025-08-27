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
        $this->queryBus = $queryBus;
    }

    public function index(Request $request)
    {
        $result = $this->queryBus->dispatch(
            new CrudQuery('Project', 'list', $request->all())
        );

        return ProjectResource::collection($result);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = $this->commandBus->dispatch(
            new CrudCommand('Project', 'create', $request->validated())
        );

        return new ProjectResource($project);
    }

    public function show($id)
    {
        $project = $this->queryBus->dispatch(
            new CrudQuery('Project', 'get', ['id' => (int)$id])
        );

        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        $payload = array_merge(['id' => (int)$id], $request->validated());

        $project = $this->commandBus->dispatch(
            new CrudCommand('Project', 'update', $payload)
        );

        return new ProjectResource($project);
    }

    public function destroy($id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Project', 'delete', ['id' => (int)$id])
        );

        return response()->json(['success' => true, 'message' => 'Project deleted']);
    }
}
