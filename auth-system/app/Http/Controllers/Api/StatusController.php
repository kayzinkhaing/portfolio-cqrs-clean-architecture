<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Resources\StatusResource;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;

class StatusController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;
    }

    /**
     * List all statuses.
     */
    public function index(Request $request)
    {
        $statuses = $this->queryBus->dispatch(
            new CrudQuery('Status', 'list', $request->all())
        );

        return StatusResource::collection($statuses)->additional([
            'meta' => [
                'count' => count($statuses),
            ],
        ]);
    }

    /**
     * Store a new status.
     */
    public function store(StoreStatusRequest $request)
    {
        $status = $this->commandBus->dispatch(
            new CrudCommand('Status', 'create', $request->validated())
        );

        return (new StatusResource($status))->response()->setStatusCode(201);
    }

    /**
     * Get a single status.
     */
    public function show(int $id)
    {
        $status = $this->queryBus->dispatch(
            new CrudQuery('Status', 'get', ['id' => $id])
        );

        return new StatusResource($status);
    }

    /**
     * Update a status.
     */
    public function update(UpdateStatusRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $status = $this->commandBus->dispatch(
            new CrudCommand('Status', 'update', $payload)
        );

        return new StatusResource($status);
    }

    /**
     * Delete a status.
     */
    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Status', 'delete', ['id' => $id])
        );

        return response()->json(null, 204);
    }
}
