<?php
namespace App\Repositories;

class TimelineItemRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(modelName: 'TimelineItem');
    }

    // Add custom methods if needed
}
