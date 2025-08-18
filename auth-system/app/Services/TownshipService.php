<?php

namespace App\Services;

use App\Repositories\TownshipRepository;

class TownshipService
{
    protected TownshipRepository $townshipRepo;

    public function __construct(TownshipRepository $townshipRepo)
    {
        $this->townshipRepo = $townshipRepo;
    }

    public function listAll()
    {
        return $this->townshipRepo->allWithWards();
    }

    public function create(array $data)
    {
        return $this->townshipRepo->create($data);
    }

    public function show($id)
    {
        return $this->townshipRepo->findById($id);
    }

    public function update($id, array $data)
    {
        return $this->townshipRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->townshipRepo->delete($id);
    }
}
