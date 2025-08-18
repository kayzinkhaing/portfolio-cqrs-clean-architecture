<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\WardRequest;
use App\Http\Resources\WardResource;
use App\Services\WardService;

class WardController extends Controller
{
    protected WardService $wardService;

    public function __construct(WardService $wardService)
    {
        $this->wardService = $wardService;
    }

    public function index()
    {
        $wards = $this->wardService->listAll();
        return WardResource::collection($wards);
    }

    public function store(WardRequest $request)
    {
        $ward = $this->wardService->create($request->validated());
        return new WardResource($ward);
    }

    public function show($id)
    {
        $ward = $this->wardService->show($id);
        return new WardResource($ward);
    }

    public function update(WardRequest $request, $id)
    {
        $ward = $this->wardService->update($id, $request->validated());
        return new WardResource($ward);
    }

    public function destroy($id)
    {
        $this->wardService->delete($id);
        return response()->json(null, 204);
    }
}
