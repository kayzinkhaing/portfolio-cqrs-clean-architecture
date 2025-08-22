<?php
namespace App\Application\Queries;

class ListWardsQuery
{
    public ?int $townshipId;

    public function __construct(?int $townshipId = null)
    {
        $this->townshipId = $townshipId;
    }
}
