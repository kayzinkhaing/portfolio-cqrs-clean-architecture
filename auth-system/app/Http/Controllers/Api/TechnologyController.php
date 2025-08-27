<?php
namespace App\Http\Controllers\Api;

use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;
use App\Http\Resources\TechnologyResource;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use Illuminate\Http\Request;

class TechnologyController extends Controller
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
            new CrudQuery('Technology', 'list', $request->all())
        );

        return TechnologyResource::collection($result);
    }

    public function store(StoreTechnologyRequest $request)
    {
        $technology = $this->commandBus->dispatch(
            new CrudCommand('Technology', 'create', $request->validated())
        );

        return new TechnologyResource($technology);
    }

    public function show($id)
    {
        $technology = $this->queryBus->dispatch(
            new CrudQuery('Technology', 'get', ['id' => (int)$id])
        );

        return new TechnologyResource($technology);
    }

    public function update(UpdateTechnologyRequest $request, $id)
    {
        $payload = array_merge(['id' => (int)$id], $request->validated());

        $technology = $this->commandBus->dispatch(
            new CrudCommand('Technology', 'update', $payload)
        );

        return new TechnologyResource($technology);
    }

    public function destroy($id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Technology', 'delete', ['id' => (int)$id])
        );

        return response()->json(['success' => true, 'message' => 'Technology deleted']);
    }
}
