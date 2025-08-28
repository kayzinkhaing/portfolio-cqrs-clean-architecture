<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEducationRequest;
use App\Http\Requests\UpdateEducationRequest;
use App\Http\Resources\EducationResource;
use App\Repositories\EducationRepository;
use Illuminate\Http\JsonResponse;

class EducationController extends Controller
{
    protected EducationRepository $repository;

    public function __construct(EducationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $educations = $this->repository->all();
        return EducationResource::collection($educations);
    }

    public function store(StoreEducationRequest $request)
    {
        $education = $this->repository->create($request->validated());
        return new EducationResource($education);
    }

    public function show(int $id)
    {
        $education = $this->repository->find($id);
        return new EducationResource($education);
    }

    public function update(UpdateEducationRequest $request, int $id)
    {
        $education = $this->repository->update($id, $request->validated());
        return new EducationResource($education);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->repository->delete($id);
        return response()->json(['success' => true, 'message' => 'Education deleted']);
    }
}
