<?php
namespace App\Repositories;

use App\Models\Technology;
use Illuminate\Database\Eloquent\Collection;

class TechnologyRepository extends BaseRepository
{

    public function __construct()
    {
        parent::__construct(modelName: 'Technology');

    }

}
