<?php

namespace App\Contracts;

use App\Contracts\BaseReadInterface;

interface BlogReadRepositoryInterface extends BaseReadInterface
{
    public function getByUser(int $userId);
}
