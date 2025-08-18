<?php

namespace App\Services;

use App\Repositories\WardRepository;

class WardService
{
    protected WardRepository $wardRepo;

    public function __construct(WardRepository $wardRepo)
    {
        $this->wardRepo = $wardRepo;
    }

    public function listAll()
    {
        return $this->wardRepo->all();
    }

    public function create(array $data)
    {
        return $this->wardRepo->create($data);
    }

    public function show($id)
    {
        return $this->wardRepo->findById($id);
    }

    public function update($id, array $data)
    {
        return $this->wardRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->wardRepo->delete($id);
    }
}
