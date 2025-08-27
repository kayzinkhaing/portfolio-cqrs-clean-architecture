<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;

abstract class CrudController extends BaseApiController
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;
    }

    public function index(Request $request)
    {
        $items = $this->queryBus->dispatch(
            $this->makeQuery('List', $request->all())
        );

        return $this->successResponse($items, "{$this->resourceName()} list retrieved successfully");
    }

    public function show($id)
    {
        $item = $this->queryBus->dispatch(
            $this->makeQuery('Get', ['id' => $id])
        );

        return $this->successResponse($item, "{$this->resourceName()} retrieved successfully");
    }

    public function store(Request $request)
    {
        $item = $this->commandBus->dispatch(
            $this->makeCommand('Create', $request->all())
        );

        return $this->successResponse($item, "{$this->resourceName()} created successfully", 201);
    }

    public function update(Request $request, $id)
    {
        $item = $this->commandBus->dispatch(
            $this->makeCommand('Update', array_merge(['id' => $id], $request->all()))
        );

        return $this->successResponse($item, "{$this->resourceName()} updated successfully");
    }

    public function destroy($id)
    {
        $this->commandBus->dispatch(
            $this->makeCommand('Delete', ['id' => $id])
        );

        return $this->successResponse(null, "{$this->resourceName()} deleted successfully");
    }

    // ----- Helper methods -----

    protected function makeCommand(string $action, array $payload)
    {
        $class = "App\\Application\\Commands\\{$action}{$this->resourceName()}Command";
        return new $class($payload);
    }

    protected function makeQuery(string $action, array $payload)
    {
        $class = "App\\Application\\Queries\\{$action}{$this->resourceName()}Query";
        return new $class($payload);
    }

    abstract protected function resourceName(): string;
}
