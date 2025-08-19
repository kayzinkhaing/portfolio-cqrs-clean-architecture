<?php

namespace App\Contracts;

interface BlogRepositoryInterface extends BaseInterface
{
    public function getByUser(int $userId);
}
