<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Http\Resources\PageResource;
use App\Repositories\PageRepository;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    protected PageRepository $repository;

    public function __construct(PageRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index()
    {
        $pages = $this->repository->all();
        return PageResource::collection($pages);
    }

    public function store(StorePageRequest $request)
    {
        $page = $this->repository->create($request->validated());
        return new PageResource($page);
    }

    public function show(int $id)
    {
        $page = $this->repository->find($id);
        return new PageResource($page);
    }

    public function update(UpdatePageRequest $request, int $id)
    {
        $page = $this->repository->update($id, $request->validated());
        return new PageResource($page);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->repository->delete($id);
        return response()->json(['success' => true, 'message' => 'Page deleted']);
    }
}
