<?php
namespace App\Application\Commands;

class ResetPasswordCommand
{
    public string $email;
    public string $token;
    public string $password;

    public function __construct(string $email, string $token, string $password)
    {
        $this->email = $email;
        $this->token = $token;
        $this->password = $password;
    }
}
