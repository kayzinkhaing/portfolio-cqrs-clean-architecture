<?php

// app/Application/Commands/LoginUserCommand.php
namespace App\Application\Commands;

class LoginUserCommand
{
    public string $email;
    public string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
}
