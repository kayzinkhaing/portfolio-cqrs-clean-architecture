<?php

namespace App\Repositories;

class ExperienceRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(modelName: 'Experience');
    }

    // Add custom Experience-specific queries if needed
}
