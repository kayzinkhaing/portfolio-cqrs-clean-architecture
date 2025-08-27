<?php
namespace App\Services;

use App\Jobs\SyncToReadModelJob;
use Illuminate\Support\Facades\Log;

class CrudService
{
    protected $repository;
    protected $modelName;

    public function __construct(string $modelName)
    {
        $this->modelName = $modelName;
        $repositoryClass = "App\\Repositories\\{$modelName}Repository";
        $this->repository = app($repositoryClass);
    }

    public function listAll()
    {
        return $this->repository->all();
    }

    public function create(array $data)
    {
        $entity = $this->repository->create($data);
        $this->dispatchSyncJob($entity->id, 'create');
        return $entity;
    }

    public function show(int $id)
    {
        return $this->repository->findById($id);
    }

    public function update(int $id, array $data)
    {
        $entity = $this->repository->update($id, $data);
        $this->dispatchSyncJob($entity->id, 'update');
        return $entity;
    }

    public function delete(int $id)
    {
        $this->repository->delete($id);
        $this->dispatchSyncJob($id, 'delete');
        return true;
    }

    protected function dispatchSyncJob(int $id, string $action = 'update')
    {
        $modelClass = "App\\Models\\{$this->modelName}";

        Log::info("Dispatching Mongo sync job for {$modelClass} ID {$id} ACTION {$action}");

        SyncToReadModelJob::dispatch($modelClass, $id, $action)
            ->onQueue('domain-events'); 
    }

}
