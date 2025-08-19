<?php

// app/Application/Buses/CommandBus.php
namespace App\Application\Buses;

class CommandBus
{
    public function dispatch($command)
    {
        $handlerClass = str_replace('Command', 'Handler', get_class($command));
        $handler = app($handlerClass);

        return $handler->handle($command);
    }
}
