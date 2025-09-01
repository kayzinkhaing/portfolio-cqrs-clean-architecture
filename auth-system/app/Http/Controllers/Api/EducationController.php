<?php

namespace App\Http\Controllers\Api;

use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use App\Http\Resources\EducationResource;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use Illuminate\Http\Request;

class EducationController extends Controller
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
            new CrudQuery('Education', 'list', $request->all())
        );

        return EducationResource::collection($result);
    }

    public function store(StoreEducationRequest $request)
    {
        $education = $this->commandBus->dispatch(
            new CrudCommand('Education', 'create', $request->validated())
        );

        return new EducationResource($education);
    }

    public function show(int $id)
    {
        $education = $this->queryBus->dispatch(
            new CrudQuery('Education', 'get', ['id' => $id])
        );

        return new EducationResource($education);
    }

    public function update(UpdateEducationRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $education = $this->commandBus->dispatch(
            new CrudCommand('Education', 'update', $payload)
        );

        return new EducationResource($education);
    }

    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Education', 'delete', ['id' => $id])
        );

        return response()->json(['success' => true, 'message' => 'Education deleted']);
    }
}
