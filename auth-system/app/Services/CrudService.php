<?
namespace App\Services;

use App\Jobs\SyncToReadModelJob;
use Illuminate\Support\Facades\Log;

class CrudService
{
    protected $repository;
    protected string $modelName;

    public function __construct(string $modelName)
    {
        $this->modelName = $modelName;
        $repositoryClass = "App\\Repositories\\{$modelName}Repository";
        // dd($repositoryClass);
        $this->repository = app($repositoryClass);
    }

    public function listAll()
    {
        return $this->repository->all();
    }

    // public function create(array $data)
    // {
    //     // dd($data);
    //     $entity = $this->repository->create($data);

    //     // Handle dynamic pivot relationships
    //     $this->syncPivotRelations($entity, $data);

    //     $this->dispatchSyncJob($entity->id, 'create');
    //     return $entity;
    // }
    public function create(array $data)
    {
        if (method_exists($this->repository, 'createWithRelations')) {
            $entity = $this->repository->createWithRelations($data);
        } else {
            $entity = $this->repository->create($data);
        }

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

        // Handle dynamic pivot relationships
        $this->syncPivotRelations($entity, $data);

        $this->dispatchSyncJob($entity->id, 'update');
        return $entity;
    }

    public function delete(int $id)
    {
        $entity = $this->repository->findById($id);

        if ($entity) {
            $entity->delete();
            $this->dispatchSyncJob($id, 'delete');
        }

        return true;
    }

    protected function dispatchSyncJob(int $id, string $action = 'update')

    {
        
        $modelClass = "App\\Models\\{$this->modelName}";

        Log::info("Dispatching Mongo sync job for {$modelClass} ID {$id} ACTION {$action}");

        SyncToReadModelJob::dispatch($modelClass, $id, $action)
            ->onQueue('domain-events');
    }

    /**
     * Dynamically sync pivot relationships if any are provided in data.
     */
    protected function syncPivotRelations($entity, array $data)
    {
        if (!$entity) return;

        foreach ($data as $key => $value) {
            if (str_ends_with($key, '_ids') && is_array($value)) {
                $relationName = str_replace('_ids', '', $key);

                if (method_exists($entity, $relationName)) {
                    // Attach pivot IDs
                    $entity->$relationName()->sync($value);
                    // Reload relationship so resource can return it
                    $entity->load($relationName);
                }
            }
        }
    }

}
?>
