<?php
namespace App\Application\Queries;

class GetWardQuery
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
