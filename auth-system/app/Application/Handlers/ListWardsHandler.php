<?php
namespace App\Application\Handlers;

use App\Application\Queries\ListWardsQuery;
use App\Services\WardService;

class ListWardsHandler
{
    protected WardService $service;

    public function __construct(WardService $service)
    {
        $this->service = $service;
    }

    public function handle(ListWardsQuery $query)
    {
        return $this->service->listAll();
    }
}
