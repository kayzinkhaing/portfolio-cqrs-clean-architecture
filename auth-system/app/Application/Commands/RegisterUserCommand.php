<?php
// app/Application/Commands/RegisterUserCommand.php
namespace App\Application\Commands;

class RegisterUserCommand
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}




