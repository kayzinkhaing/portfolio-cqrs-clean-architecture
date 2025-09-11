<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Application\Buses\CommandBus;
use App\Application\Buses\QueryBus;
use App\Application\Commands\CrudCommand;
use App\Application\Queries\CrudQuery;
use App\Http\Requests\StoreTestimonialRequest;
use App\Http\Requests\UpdateTestimonialRequest;
use App\Http\Resources\TestimonialResource;

class TestimonialController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus   = $queryBus;
    }

    /**
     * List all testimonials.
     */
    public function index(Request $request)
    {
        $testimonials = $this->queryBus->dispatch(
            new CrudQuery('Testimonial', 'list', $request->all())
        );

        return TestimonialResource::collection($testimonials)->additional([
            'meta' => ['count' => count($testimonials)],
        ]);
    }

    /**
     * Store a new testimonial.
     */
    public function store(StoreTestimonialRequest $request)
    {
        $testimonial = $this->commandBus->dispatch(
            new CrudCommand('Testimonial', 'create', $request->validated())
        );

        return (new TestimonialResource($testimonial))->response()->setStatusCode(201);
    }

    /**
     * Get a single testimonial.
     */
    public function show(int $id)
    {
        $testimonial = $this->queryBus->dispatch(
            new CrudQuery('Testimonial', 'get', ['id' => $id])
        );

        return new TestimonialResource($testimonial);
    }

    /**
     * Update a testimonial.
     */
    public function update(UpdateTestimonialRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $testimonial = $this->commandBus->dispatch(
            new CrudCommand('Testimonial', 'update', $payload)
        );

        return new TestimonialResource($testimonial);
    }

    /**
     * Delete a testimonial.
     */
    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('Testimonial', 'delete', ['id' => $id])
        );

        return response()->json(null, 204);
    }
}
