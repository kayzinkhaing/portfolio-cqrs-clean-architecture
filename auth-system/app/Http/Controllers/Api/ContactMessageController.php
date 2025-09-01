<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Application\Buses\QueryBus;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Mail\ContactMessageReceived;
use Illuminate\Support\Facades\Mail;
use App\Application\Buses\CommandBus;
use App\Application\Queries\CrudQuery;
use App\Application\Commands\CrudCommand;
use App\Http\Resources\ContactMessageResource;
use App\Http\Requests\StoreContactMessageRequest;

class ContactMessageController extends Controller
{
    protected CommandBus $commandBus;
    protected QueryBus $queryBus;

    public function __construct(CommandBus $commandBus, QueryBus $queryBus)
    {
        $this->commandBus = $commandBus;
        $this->queryBus = $queryBus;
    }

    // List all messages (for admin)
    public function index(Request $request)
    {
        $messages = $this->queryBus->dispatch(
            new CrudQuery('ContactMessage', 'list', $request->all())
        );

        return ContactMessageResource::collection($messages);
    }

    // Store message and send email
    public function store(StoreContactMessageRequest $request)
    {
        // 1️⃣ Store in DB via CQRS command
        $contactMessage = $this->commandBus->dispatch(
            new CrudCommand('ContactMessage', 'create', $request->validated())
        );

        // 2️⃣ Send email to admin (synchronously)
        try {
            Mail::to(config('mail.admin_email'))
                ->send(new ContactMessageReceived($contactMessage));
        } catch (\Exception $e) {
            // Log email failure, but still return success response
            Log::error('Failed to send contact message email: ' . $e->getMessage());
        }

        // 3️⃣ Return saved message as JSON resource
        return new ContactMessageResource($contactMessage);
    }
    // Optional: mark message as read
    public function markAsRead($id)
    {
        $message = $this->commandBus->dispatch(
            new CrudCommand('ContactMessage', 'update', ['id' => (int)$id, 'is_read' => true])
        );

        return new ContactMessageResource($message);
    }
}
