<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TownshipStoreRequest;
use App\Http\Requests\TownshipUpdateRequest;
use App\Http\Resources\TownshipResource;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use App\Application\Commands\CreateTownshipCommand;
use App\Application\Commands\UpdateTownshipCommand;
use App\Application\Commands\DeleteTownshipCommand;
use App\Application\Queries\GetTownshipQuery;
use App\Application\Queries\ListTownshipsQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TownshipController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    // GET /townships
    public function index(): JsonResponse
    {
        $townships = $this->queryBus->dispatch(new ListTownshipsQuery());

        return response()->json([
            'success' => true,
            'data' => TownshipResource::collection($townships),
        ]);
    }

    // POST /townships
    public function store(TownshipStoreRequest $request): JsonResponse
    {
        // dd("here");
        $township = $this->commandBus->dispatch(
            new CreateTownshipCommand($request->validated())
        );

        return response()->json([
            'success' => true,
            'data' => new TownshipResource($township),
        ], 201);
    }

    // GET /townships/{id}
    public function show($id): JsonResponse
    {
        $township = $this->queryBus->dispatch(new GetTownshipQuery($id));

        return response()->json([
            'success' => true,
            'data' => new TownshipResource($township),
        ]);
    }

    // PUT/PATCH /townships/{id}
    public function update(TownshipUpdateRequest $request, $id): JsonResponse
    {
        $township = $this->commandBus->dispatch(
            new UpdateTownshipCommand($id, $request->validated())
        );

        return response()->json([
            'success' => true,
            'data' => new TownshipResource($township),
        ]);
    }

    // DELETE /townships/{id}
    public function destroy($id): JsonResponse
    {
        $this->commandBus->dispatch(new DeleteTownshipCommand($id));

        return response()->json([
            'success' => true,
            'message' => 'Township deleted successfully',
        ], 204);
    }
}
