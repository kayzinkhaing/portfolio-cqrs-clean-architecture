<?php
namespace App\Application\Commands;

class CreateTownshipCommand
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
