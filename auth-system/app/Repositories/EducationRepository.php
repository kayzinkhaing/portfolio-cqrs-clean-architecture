<?php

namespace App\Repositories;

class EducationRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(modelName: 'Education');
    }

    // Add custom Education-specific queries if needed
}
