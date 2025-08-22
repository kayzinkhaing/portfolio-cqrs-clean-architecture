<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WardRequest;
use App\Http\Resources\WardResource;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use App\Application\Commands\CreateWardCommand;
use App\Application\Commands\UpdateWardCommand;
use App\Application\Commands\DeleteWardCommand;
use App\Application\Queries\GetWardQuery;
use App\Application\Queries\ListWardsQuery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WardController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    public function index(): JsonResponse
    {
        $wards = $this->queryBus->dispatch(new ListWardsQuery());

        return response()->json([
            'success' => true,
            'data' => WardResource::collection($wards),
        ]);
    }

    public function store(WardRequest $request): JsonResponse
    {
        $ward = $this->commandBus->dispatch(
            new CreateWardCommand($request->validated())
        );

        return response()->json([
            'success' => true,
            'data' => new WardResource($ward),
        ], 201);
    }

    public function show($id): JsonResponse
    {
        $ward = $this->queryBus->dispatch(new GetWardQuery($id));

        return response()->json([
            'success' => true,
            'data' => new WardResource($ward),
        ]);
    }

    public function update(WardRequest $request, $id): JsonResponse
    {
        $ward = $this->commandBus->dispatch(
            new UpdateWardCommand($id, $request->validated())
        );

        return response()->json([
            'success' => true,
            'data' => new WardResource($ward),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $this->commandBus->dispatch(new DeleteWardCommand($id));

        return response()->json([
            'success' => true,
            'message' => 'Ward deleted successfully',
        ], 204);
    }
}
