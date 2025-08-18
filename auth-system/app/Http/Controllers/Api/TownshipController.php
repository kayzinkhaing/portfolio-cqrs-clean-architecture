<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TownshipStoreRequest;
use App\Http\Requests\TownshipUpdateRequest;
use App\Http\Resources\TownshipResource;
use App\Services\TownshipService;

class TownshipController extends Controller
{
    protected TownshipService $townshipService;

    public function __construct(TownshipService $townshipService)
    {
        $this->townshipService = $townshipService;
    }

    public function index()
    {
        $townships = $this->townshipService->listAll();
        return TownshipResource::collection($townships);
    }

    public function store(TownshipStoreRequest $request)
    {
        $township = $this->townshipService->create($request->validated());
        return new TownshipResource($township);
    }

    public function show($id)
    {
        $township = $this->townshipService->show($id);
        return new TownshipResource($township);
    }

    public function update(TownshipUpdateRequest $request, $id)
    {
        $township = $this->townshipService->update($id, $request->validated());
        return new TownshipResource($township);
    }

    public function destroy($id)
    {
        $this->townshipService->delete($id);
        return response()->json(null, 204);
    }
}
