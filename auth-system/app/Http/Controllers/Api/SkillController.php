<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Resources\SkillResource;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;

class SkillController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;
    }

    /**
     * List all skills.
     */
    public function index(Request $request)
    {
        $skills = $this->queryBus->dispatch(
            new CrudQuery('Skill', 'list', $request->all())
        );

        return SkillResource::collection($skills)->additional([
            'meta' => [
                'count' => count($skills),
            ],
        ]);
    }

    /**
     * Store a new skill.
     */
    public function store(StoreSkillRequest $request)
    {
        $skill = $this->commandBus->dispatch(
            new CrudCommand('Skill', 'create', $request->validated())
        );

        return (new SkillResource($skill))->response()->setStatusCode(201);
    }

    /**
     * Get a single skill.
     */
    public function show(int $id)
    {
        $skill = $this->queryBus->dispatch(
            new CrudQuery('Skill', 'get', ['id' => $id])
        );

        return new SkillResource($skill);
    }

    /**
     * Update a skill.
     */
    public function update(UpdateSkillRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $skill = $this->commandBus->dispatch(
            new CrudCommand('Skill', 'update', $payload)
        );

        return new SkillResource($skill);
    }

    /**
     * Delete a skill.
     */
    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Skill', 'delete', ['id' => $id])
        );

        return response()->json(null, 204);
    }
}
