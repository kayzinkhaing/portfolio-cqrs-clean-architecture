<?php
namespace App\Application\Commands;

class DeleteWardCommand
{
    public int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
