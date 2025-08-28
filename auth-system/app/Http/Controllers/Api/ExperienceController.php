<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExperienceRequest;
use App\Http\Requests\UpdateExperienceRequest;
use App\Http\Resources\ExperienceResource;
use App\Repositories\ExperienceRepository;
use Illuminate\Http\JsonResponse;

class ExperienceController extends Controller
{
    protected ExperienceRepository $repository;

    public function __construct(ExperienceRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        return ExperienceResource::collection($this->repository->all());
    }

    public function store(StoreExperienceRequest $request)
    {
        $experience = $this->repository->create($request->validated());
        return new ExperienceResource($experience);
    }

    public function show(int $id)
    {
        $experience = $this->repository->find($id);
        return new ExperienceResource($experience);
    }

    public function update(UpdateExperienceRequest $request, int $id)
    {
        $experience = $this->repository->update($id, $request->validated());
        return new ExperienceResource($experience);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->repository->delete($id);
        return response()->json(['success' => true, 'message' => 'Experience deleted']);
    }
}
