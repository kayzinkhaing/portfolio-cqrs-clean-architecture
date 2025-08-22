<?php
namespace App\Application\Handlers;

use App\Application\Queries\GetWardQuery;
use App\Services\WardService;

class GetWardHandler
{
    protected WardService $service;

    public function __construct(WardService $service)
    {
        $this->service = $service;
    }

    public function handle(GetWardQuery $query)
    {
        return $this->service->show($query->id);
    }
}
