<?php

namespace App\Http\Controllers\Api;

use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Http\Resources\TestimonialResource;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use Illuminate\Http\Request;

class TestimonialController extends Controller
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
            new CrudQuery('Testimonial', 'list', $request->all())
        );

        return TestimonialResource::collection($result);
    }

    public function store(StoreTestimonialRequest $request)
    {
        $testimonial = $this->commandBus->dispatch(
            new CrudCommand('Testimonial', 'create', $request->validated())
        );

        return new TestimonialResource($testimonial);
    }

    public function show($id)
    {
        $testimonial = $this->queryBus->dispatch(
            new CrudQuery('Testimonial', 'get', ['id' => (int)$id])
        );

        return new TestimonialResource($testimonial);
    }

    public function update(UpdateTestimonialRequest $request, $id)
    {
        $payload = array_merge(['id' => (int)$id], $request->validated());

        $testimonial = $this->commandBus->dispatch(
            new CrudCommand('Testimonial', 'update', $payload)
        );

        return new TestimonialResource($testimonial);
    }

    public function destroy($id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Testimonial', 'delete', ['id' => (int)$id])
        );

        return response()->json(['success' => true, 'message' => 'Testimonial deleted']);
    }
}
