<?php
namespace App\Services;

use App\Events\ModelChanged;
use Illuminate\Support\Facades\Log;

class CrudService
{
    protected $repository;
    protected string $modelName;

    public function __construct(string $modelName)
    {
        $this->modelName = $modelName;
        $repositoryClass = "App\\Repositories\\{$modelName}Repository";
        // dd($repositoryClass);//"App\Repositories\ProjectRepository" // app/Services/CrudService.php:16
        $this->repository = app($repositoryClass);
        // dd($this->repository);
    }

    public function listAll()
    {
        return $this->repository->all();
    }

    public function create(array $data)
    {
        // dd($data);
        $entity = method_exists($this->repository, 'createWithRelations')
            ? $this->repository->createWithRelations($data)
            : $this->repository->create($data);

            // dd($entity);

        $this->dispatchModelChangedEvent($entity, 'create');

        return $entity;
    }

    public function show(int $id)
    {
        return $this->repository->findById($id);
    }

    public function update(int $id, array $data)
    {
        $entity = method_exists($this->repository, 'updateWithRelations')
            ? $this->repository->updateWithRelations($id, $data)
            : $this->repository->update($id, $data);

        $this->syncPivotRelations($entity, $data);
        $this->dispatchModelChangedEvent($entity->id, 'update');

        return $entity;
    }

    public function delete(int $id)
    {
        $entity = $this->repository->findById($id);
        if ($entity) {
            $entity->delete();
            $this->dispatchModelChangedEvent($id, 'delete');
        }
        return true;
    }

    /** Dispatch domain event instead of direct job */
    protected function dispatchModelChangedEvent($model, string $action = 'update')
{
    // $model can be any Eloquent model
    event(new ModelChanged($model, $action));
}


    /** Dynamically sync pivot relationships if any */
    protected function syncPivotRelations($entity, array $data)
    {
        if (!$entity) return;

        foreach ($data as $key => $value) {
            if (str_ends_with($key, '_ids') && is_array($value)) {
                $relation = str_replace('_ids', '', $key);
                if (method_exists($entity, $relation)) {
                    $entity->$relation()->sync($value);
                    $entity->load($relation);
                }
            }
        }
    }
}
