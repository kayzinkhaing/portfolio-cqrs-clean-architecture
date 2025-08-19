<?php

namespace App\Application\Commands;

class SendPasswordResetLinkCommand
{
    public string $email;

    public function __construct(string $email)
    {
        $this->email = $email;
    }
}
