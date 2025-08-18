<?php

namespace App\Contracts;

interface UserRepositoryInterface extends BaseInterface
{
    public function findByEmail(string $email);
}
