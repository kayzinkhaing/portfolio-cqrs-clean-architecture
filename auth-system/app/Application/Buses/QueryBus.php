<?php
namespace App\Application\Buses;

class QueryBus
{
    public function dispatch($query)
    {
        $queryClass = get_class($query); // e.g., App\Application\Queries\CrudQuery
        $short = class_basename($queryClass); // CrudQuery
        $handlerClass = $this->resolveHandlerClass($short);

        if (!class_exists($handlerClass)) {
            throw new \RuntimeException("Query handler {$handlerClass} not found.");
        }

        $handler = app($handlerClass);
        return $handler->handle($query);
    }

   protected function resolveHandlerClass(string $shortName): string
{
    if ($shortName === 'CrudQuery') {
        return "App\\Application\\Handlers\\CrudQueryHandler";
    }

    return "App\\Application\\Handlers\\" . str_replace('Query', 'Handler', $shortName);
}

}
