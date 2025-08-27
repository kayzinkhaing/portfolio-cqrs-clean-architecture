<?php
namespace App\Http\Controllers\Api;

use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreStatusRequest;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Resources\StatusResource;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use Illuminate\Http\Request;

class StatusController extends Controller
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
        // dd($request->all());
        $result = $this->queryBus->dispatch(
            new CrudQuery('Status', 'list', $request->all())
        );

        return StatusResource::collection($result);
    }

    public function store(StoreStatusRequest $request)
    {
        $status = $this->commandBus->dispatch(
            new CrudCommand('Status', 'create', $request->validated())
        );

        return new StatusResource($status);
    }

    public function show($id)
    {
        $status = $this->queryBus->dispatch(
            new CrudQuery('Status', 'get', ['id' => (int)$id])
        );

        return new StatusResource($status);
    }

    public function update(UpdateStatusRequest $request, $id)
    {
        $payload = array_merge(['id' => (int)$id], $request->validated());

        $status = $this->commandBus->dispatch(
            new CrudCommand('Status', 'update', $payload)
        );

        return new StatusResource($status);
    }

    public function destroy($id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Status', 'delete', ['id' => (int)$id])
        );

        return response()->json(['success' => true, 'message' => 'Status deleted']);
    }
}
