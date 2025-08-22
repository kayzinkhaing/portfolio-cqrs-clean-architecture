<?php
namespace App\Application\Commands;

class UpdateWardCommand
{
    public int $id;
    public array $data;

    public function __construct(int $id, array $data)
    {
        $this->id = $id;
        $this->data = $data;
    }
}
