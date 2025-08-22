<?php
namespace App\Application\Handlers;

use App\Application\Queries\ListTownshipsQuery;
use App\Services\TownshipService;

class ListTownshipsHandler
{
    protected TownshipService $service;

    public function __construct(TownshipService $service)
    {
        $this->service = $service;
    }

    public function handle(ListTownshipsQuery $query)
    {
        return $this->service->listAll();
    }
}
