<?php
namespace App\Repositories;

class StatusRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(modelName: 'Status');
    }

    // add extra status-specific queries if needed
}
