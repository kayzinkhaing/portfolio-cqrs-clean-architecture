<?php

// app/Application/Queries/GetUserProfileQuery.php
namespace App\Application\Queries;

use App\Models\User;

class GetUserProfileQuery
{
    public User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
