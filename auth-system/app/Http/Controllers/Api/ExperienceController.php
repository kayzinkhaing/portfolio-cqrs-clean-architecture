<?php

namespace App\Http\Controllers\Api;

use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Http\Resources\ExperienceResource;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use Illuminate\Http\Request;

class ExperienceController extends Controller
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
            new CrudQuery('Experience', 'list', $request->all())
        );

        return ExperienceResource::collection($result);
    }

    public function store(StoreExperienceRequest $request)
    {
        $experience = $this->commandBus->dispatch(
            new CrudCommand('Experience', 'create', $request->validated())
        );

        return new ExperienceResource($experience);
    }

    public function show(int $id)
    {
        $experience = $this->queryBus->dispatch(
            new CrudQuery('Experience', 'get', ['id' => $id])
        );

        return new ExperienceResource($experience);
    }

    public function update(UpdateExperienceRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $experience = $this->commandBus->dispatch(
            new CrudCommand('Experience', 'update', $payload)
        );

        return new ExperienceResource($experience);
    }

    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Experience', 'delete', ['id' => $id])
        );

        return response()->json(['success' => true, 'message' => 'Experience deleted']);
    }
}
