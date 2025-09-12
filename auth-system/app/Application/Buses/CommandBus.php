<?php

namespace App\Application\Buses;

use App\Traits\RetryableAction;
use Illuminate\Contracts\Container\Container;

class CommandBus
{
    use RetryableAction;

    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function dispatch($command)
    {
        $handlerClass = $this->getHandlerClass($command);

        if (! class_exists($handlerClass)) {
            throw new \RuntimeException("Handler [$handlerClass] not found for command " . get_class($command));
        }

        $handler = $this->container->make($handlerClass);

        return $this->retry(fn() => $handler->handle($command));
    }

    protected function getHandlerClass($command): string
    {
        // Convention: Replace "Command" with "Handler"
        return str_replace('Commands', 'Handlers', get_class($command)) . 'Handler';
    }
}

