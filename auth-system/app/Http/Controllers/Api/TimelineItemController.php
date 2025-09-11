<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Requests\StoreTimelineItemRequest;
use App\Http\Requests\UpdateTimelineItemRequest;
use App\Http\Resources\TimelineItemResource;

class TimelineItemController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;
    }

    /**
     * List all timeline items.
     */
    public function index(Request $request)
    {
        $items = $this->queryBus->dispatch(
            new CrudQuery('TimelineItem', 'list', $request->all())
        );

        return TimelineItemResource::collection($items)->additional([
            'meta' => ['count' => count($items)],
        ]);
    }

    /**
     * Store a new timeline item.
     */
    public function store(StoreTimelineItemRequest $request)
    {
        $item = $this->commandBus->dispatch(
            new CrudCommand('TimelineItem', 'create', $request->validated())
        );

        return (new TimelineItemResource($item))->response()->setStatusCode(201);
    }

    /**
     * Get a single timeline item.
     */
    public function show(int $id)
    {
        $item = $this->queryBus->dispatch(
            new CrudQuery('TimelineItem', 'get', ['id' => $id])
        );

        return new TimelineItemResource($item);
    }

    /**
     * Update a timeline item.
     */
    public function update(UpdateTimelineItemRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $item = $this->commandBus->dispatch(
            new CrudCommand('TimelineItem', 'update', $payload)
        );

        return new TimelineItemResource($item);
    }

    /**
     * Delete a timeline item.
     */
    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('TimelineItem', 'delete', ['id' => $id])
        );

        return response()->json(null, 204);
    }
}
