<?php

namespace App\Repositories;

use App\Contracts\BaseInterface;
use App\Models\Ward;

class WardRepository extends BaseRepository implements BaseInterface
{
    public function __construct()
    {
        parent::__construct('Ward');
    }

    // Additional Ward-specific methods can go here
    public function getByTownship($townshipId)
    {
        return $this->currentModel->where('township_id', $townshipId)->get();
    }
}
