<?php

namespace App\Application\Handlers;

use App\Application\Queries\GetUserProfileQuery;

class GetUserProfileHandler
{
    public function handle(GetUserProfileQuery $query)
    {
        // Return the user with relations loaded
        return $query->user->load(['township', 'ward']);
    }
}
