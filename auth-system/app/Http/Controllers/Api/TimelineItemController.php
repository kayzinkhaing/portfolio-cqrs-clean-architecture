<?php

namespace App\Http\Controllers\Api;

use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTimelineItemRequest;
use App\Http\Requests\UpdateTimelineItemRequest;
use App\Http\Resources\TimelineItemResource;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use Illuminate\Http\Request;

class TimelineItemController extends Controller
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
            new CrudQuery('TimelineItem', 'list', $request->all())
        );

        return TimelineItemResource::collection($result);
    }

    public function store(StoreTimelineItemRequest $request)
    {
        $item = $this->commandBus->dispatch(
            new CrudCommand('TimelineItem', 'create', $request->validated())
        );

        return new TimelineItemResource($item);
    }

    public function show($id)
    {
        $item = $this->queryBus->dispatch(
            new CrudQuery('TimelineItem', 'get', ['id' => (int)$id])
        );

        return new TimelineItemResource($item);
    }

    public function update(UpdateTimelineItemRequest $request, $id)
    {
        $payload = array_merge(['id' => (int)$id], $request->validated());

        $item = $this->commandBus->dispatch(
            new CrudCommand('TimelineItem', 'update', $payload)
        );

        return new TimelineItemResource($item);
    }

    public function destroy($id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('TimelineItem', 'delete', ['id' => (int)$id])
        );

        return response()->json(['success' => true, 'message' => 'Timeline item deleted']);
    }
}
