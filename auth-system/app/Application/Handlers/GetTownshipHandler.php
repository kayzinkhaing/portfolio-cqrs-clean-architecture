<?php
namespace App\Application\Handlers;

use App\Application\Queries\GetTownshipQuery;
use App\Services\TownshipService;

class GetTownshipHandler
{
    protected TownshipService $service;

    public function __construct(TownshipService $service)
    {
        $this->service = $service;
    }

    public function handle(GetTownshipQuery $query)
    {
        return $this->service->show($query->id);
    }
}
