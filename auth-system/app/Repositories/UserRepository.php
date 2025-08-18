<?php

namespace App\Repositories;

use App\Contracts\UserRepositoryInterface;
use App\Models\User;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        parent::__construct('User'); // BaseRepository expects modelName
    }

    public function findByEmail(string $email)
    {
        return $this->currentModel->where('email', $email)->first();
    }
}
