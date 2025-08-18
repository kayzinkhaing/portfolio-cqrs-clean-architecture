<?php

namespace App\Repositories;

use App\Contracts\BaseInterface;
use App\Models\Township;

class TownshipRepository extends BaseRepository implements BaseInterface
{
    public function __construct()
    {
        parent::__construct('Township');
    }

    // Custom method to get township with wards
    public function allWithWards()
    {
        return $this->currentModel->with('wards:id,name,township_id')
                                  ->select('id', 'name')
                                  ->get();
    }
}
