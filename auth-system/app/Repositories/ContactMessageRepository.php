<?php
namespace App\Repositories;

class ContactMessageRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(modelName: 'ContactMessage');
    }

    // add extra status-specific queries if needed
}
