<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Application\Buses\QueryBus;
use App\Application\Buses\CommandBus;
use App\Application\Queries\CrudQuery;
use App\Application\Commands\CrudCommand;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactMessageResource;
use App\Http\Requests\StoreContactMessageRequest;
use App\Http\Requests\UpdateContactMessageRequest;
use App\Services\NotificationService;

class ContactMessageController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;
    protected NotificationService $notificationService;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus, NotificationService $notificationService)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
        $this->notificationService = $notificationService;
    }

    /**
     * List all messages (with optional pagination & filters)
     */
    public function index(Request $request)
    {
        $messages = $this->queryBus->dispatch(
            new CrudQuery('ContactMessage', 'list', $request->all())
        );

        return ContactMessageResource::collection($messages)->additional([
            'meta' => ['count' => count($messages)]
        ]);
    }

    /**
     * Store a new contact message (write in MySQL, send email)
     */
    public function store(StoreContactMessageRequest $request)
    {
        $contactMessage = $this->commandBus->dispatch(
            new CrudCommand('ContactMessage', 'create', $request->validated())
        );

        // Send email with retry strategy
        $this->notificationService->sendContactMessageEmail($contactMessage);

        return (new ContactMessageResource($contactMessage))
            ->response()
            ->setStatusCode(201);
    }

    public function update(UpdateContactMessageRequest $request, int $id)
    {
        $payload = array_merge(['id' => $id], $request->validated());

        $contactMessage = $this->commandBus->dispatch(
            new CrudCommand('ContactMessage', 'update', $payload)
        );

        return new ContactMessageResource($contactMessage);
    }

    public function destroy(int $id)
    {
        $this->commandBus->dispatch(
            new CrudCommand('ContactMessage', 'delete', ['id' => $id])
        );

        return response()->json(null, 204);
    }

    /**
     * Get unread messages count and list (read from Mongo)
     */
    public function unread()
    {
        $messages = $this->queryBus->dispatch(
            new CrudQuery('ContactMessage', 'list', ['filter' => ['is_read' => false]])
        );

        return response()->json([
            'data' => ContactMessageResource::collection($messages),
            'meta' => ['count' => count($messages)]
        ]);
    }
}
