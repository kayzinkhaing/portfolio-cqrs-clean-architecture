<?php
namespace App\Application\Queries;

class GetTownshipQuery
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
