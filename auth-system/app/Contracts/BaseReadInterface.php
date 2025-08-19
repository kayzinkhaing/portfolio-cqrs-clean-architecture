<?php

namespace App\Contracts;

interface BaseReadInterface
{
    public function findById($id);
    public function getAll(array $filters = []);
    public function delete($id);
}
