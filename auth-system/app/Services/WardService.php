<?php

namespace App\Services;

use App\Repositories\WardRepository;
use App\Jobs\SyncWardToReadModel;

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
        $ward = $this->wardRepo->create($data);
        SyncWardToReadModel::dispatch($ward->id);
        return $ward;
    }

    public function show(int $id)
    {
        return $this->wardRepo->findById($id);
    }

    public function update(int $id, array $data)
    {
        $ward = $this->wardRepo->update($id, $data);
        SyncWardToReadModel::dispatch($ward->id);
        return $ward;
    }

    public function delete(int $id)
    {
        $this->wardRepo->delete($id);
        SyncWardToReadModel::dispatch($id, 'delete');
        return true;
    }
}
