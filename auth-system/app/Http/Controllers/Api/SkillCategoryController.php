<?php
namespace App\Http\Controllers\Api;

use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSkillCategoryRequest;
use App\Http\Requests\UpdateSkillCategoryRequest;
use App\Http\Resources\SkillCategoryResource;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use Illuminate\Http\Request;

class SkillCategoryController extends Controller
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
            new CrudQuery('SkillCategory', 'list', $request->all())
        );

        return SkillCategoryResource::collection($result);
    }

    public function store(StoreSkillCategoryRequest $request)
    {
        // dd("here");
        // dd($request->all());
        $skillCategory = $this->commandBus->dispatch(
            new CrudCommand('SkillCategory', 'create', $request->validated())
        );

        return new SkillCategoryResource($skillCategory);
    }

    public function show($id)
    {
        $skillCategory = $this->queryBus->dispatch(
            new CrudQuery('SkillCategory', 'get', ['id' => (int)$id])
        );

        return new SkillCategoryResource($skillCategory);
    }

    public function update(UpdateSkillCategoryRequest $request, $id)
    {
        $payload = array_merge(['id' => (int)$id], $request->validated());

        $skillCategory = $this->commandBus->dispatch(
            new CrudCommand('SkillCategory', 'update', $payload)
        );

        return new SkillCategoryResource($skillCategory);
    }

    public function destroy($id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('SkillCategory', 'delete', ['id' => (int)$id])
        );

        return response()->json(['success' => true, 'message' => 'Skill Category deleted']);
    }
}
