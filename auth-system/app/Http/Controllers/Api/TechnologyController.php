<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Resources\TechnologyResource;
use App\Http\Requests\StoreTechnologyRequest;
use App\Http\Requests\UpdateTechnologyRequest;

class TechnologyController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;
    }

    /**
     * List all technologies.
     */
    public function index(Request $request)
    {
        $technologies = $this->queryBus->dispatch(
            new CrudQuery('Technology', 'list', $request->all())
        );

        return TechnologyResource::collection($technologies)->additional([
            'meta' => [
                'count' => count($technologies),
            ],
        ]);
    }

    /**
     * Store a new technology.
     */
    public function store(StoreTechnologyRequest $request)
    {
        $technology = $this->commandBus->dispatch(
            new CrudCommand('Technology', 'create', $request->validated())
        );

        return (new TechnologyResource($technology))->response()->setStatusCode(201);
    }

    /**
     * Get a single technology.
     */
    public function show(int $id)
    {
        $technology = $this->queryBus->dispatch(
            new CrudQuery('Technology', 'get', ['id' => $id])
        );

        return new TechnologyResource($technology);
    }

    /**
     * Update a technology.
     */
    public function update(UpdateTechnologyRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $technology = $this->commandBus->dispatch(
            new CrudCommand('Technology', 'update', $payload)
        );

        return new TechnologyResource($technology);
    }

    /**
     * Delete a technology.
     */
    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Technology', 'delete', ['id' => $id])
        );

        return response()->json(null, 204);
    }
}
