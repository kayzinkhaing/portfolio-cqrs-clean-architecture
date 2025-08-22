<?php
namespace App\Application\Commands;

class CreateWardCommand
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
