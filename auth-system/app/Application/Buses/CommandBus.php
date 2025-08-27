<?php
namespace App\Application\Buses;

class CommandBus
{
    public function dispatch($command)
    {
        $commandClass = get_class($command); // e.g., App\Application\Commands\CrudCommand
        $short = class_basename($commandClass); // CrudCommand
        $handlerClass = $this->resolveHandlerClass(shortName: $short);

        if (!class_exists($handlerClass)) {
            throw new \RuntimeException("Command handler {$handlerClass} not found.");
        }

        $handler = app($handlerClass);
        return $handler->handle($command);
    }

    protected function resolveHandlerClass(string $shortName): string
    {
        // If it's a CrudCommand or CrudQuery, map to CrudCommandHandler or CrudQueryHandler
        if (str_contains($shortName, needle: 'Crud')) {
            return "App\\Application\\Handlers\\{$shortName}Handler"; // CrudCommandHandler
        }

        // Default mapping: Replace 'Command' with 'Handler'
        return "App\\Application\\Handlers\\" . str_replace('Command', 'Handler', $shortName);
    }
}
