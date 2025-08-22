<?php

namespace App\Services;

use App\Repositories\TownshipRepository;
use App\Jobs\SyncTownshipToReadModel;

class TownshipService
{
    protected TownshipRepository $townshipRepo;

    public function __construct(TownshipRepository $townshipRepo)
    {
        $this->townshipRepo = $townshipRepo;
    }

    public function listAll()
    {
        // Fetch all townships with wards
        return $this->townshipRepo->allWithWards();
    }

    public function create(array $data)
    {
        $township = $this->townshipRepo->create($data);

        // Optional: dispatch CQRS job to sync with a read model or cache
        SyncTownshipToReadModel::dispatch($township->id);

        return $township;
    }

    public function show(int $id)
    {
        return $this->townshipRepo->findById($id);
    }

    public function update(int $id, array $data)
    {
        $township = $this->townshipRepo->update($id, $data);

        // Optional: sync updated township to read model
        SyncTownshipToReadModel::dispatch($township->id);

        return $township;
    }

    public function delete(int $id)
    {
        $this->townshipRepo->delete($id);

        // Optional: remove from read model or cache
        SyncTownshipToReadModel::dispatch($id, 'delete');

        return true;
    }
}
