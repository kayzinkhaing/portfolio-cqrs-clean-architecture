<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Resources\EducationResource;
use App\Http\Requests\StoreEducationRequest;
use App\Http\Requests\UpdateEducationRequest;

class EducationController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    /**
     * List all education records with optional pagination and filters.
     */
    public function index(Request $request)
    {
        $result = $this->queryBus->dispatch(
            new CrudQuery('Education', 'list', $request->all())
        );

        return EducationResource::collection($result)->additional([
            'meta' => [
                'count' => count($result),
            ],
        ]);
    }

    /**
     * Store a new education record.
     */
    public function store(StoreEducationRequest $request)
    {
        $education = $this->commandBus->dispatch(
            new CrudCommand('Education', 'create', $request->validated())
        );

        return (new EducationResource($education))
            ->response()
            ->setStatusCode(201); // REST: 201 Created
    }

    /**
     * Get a single education record.
     */
    public function show(int $id)
    {
        $education = $this->queryBus->dispatch(
            new CrudQuery('Education', 'get', ['id' => $id])
        );

        return new EducationResource($education);
    }

    /**
     * Update an existing education record.
     */
    public function update(UpdateEducationRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $education = $this->commandBus->dispatch(
            new CrudCommand('Education', 'update', $payload)
        );

        return new EducationResource($education);
    }

    /**
     * Delete an education record.
     */
    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Education', 'delete', ['id' => $id])
        );

        return response()->json(null, 204); // REST: No Content
    }
}
