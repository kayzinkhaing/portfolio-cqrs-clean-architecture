<?php

namespace App\Application\Buses;

use App\Application\Handlers\CrudCommandHandler;
use App\Traits\RetryableAction;

class CommandBus
{
    use RetryableAction;

    protected CrudCommandHandler $handler;

    public function __construct(CrudCommandHandler $handler)
    {
        $this->handler = $handler;
    }

    public function dispatch($command)
    {
        // All command handling now automatically has retry + logging
        return $this->retry(fn() => $this->handler->handle($command));
    }
}
