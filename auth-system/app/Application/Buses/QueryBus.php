<?php


// app/Application/Buses/QueryBus.php
namespace App\Application\Buses;

class QueryBus
{
    public function dispatch($query)
    {
        $handlerClass = str_replace('Query', 'Handler', get_class($query));
        $handler = app($handlerClass);

        return $handler->handle($query);
    }
}
