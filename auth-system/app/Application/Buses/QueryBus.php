<?php


// app/Application/Buses/QueryBus.php
namespace App\Application\Buses;

class QueryBus
{
    public function dispatch($query)
    {
        $queryClass = get_class($query);

        // Replace "Queries" with "Handlers" AND "Query" with "Handler"
        $handlerClass = str_replace(
            ['Queries', 'Query'],
            ['Handlers', 'Handler'],
            $queryClass
        );

        $handler = app($handlerClass);

        return $handler->handle($query);
    }
}

