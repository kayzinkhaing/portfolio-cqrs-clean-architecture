<?php
namespace App\Application\Commands;

class DeleteTownshipCommand
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
