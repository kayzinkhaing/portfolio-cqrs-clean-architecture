<?php

namespace App\Repositories;

use App\Traits\Media;
use InvalidArgumentException;
use App\Contracts\BaseInterface;
use Illuminate\Http\UploadedFile;
use App\Traits\HandlesRepositoryErrors;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseRepository implements BaseInterface
{
    use Media, HandlesRepositoryErrors;

    public Model $currentModel;
    protected string $currentTable;

    public function __construct(string $modelName)
    {
        if (empty($modelName)) {
            throw new InvalidArgumentException('Model name cannot be empty.');
        }

        $this->currentModel = app("App\\Models\\{$modelName}");
        $this->currentTable = $this->currentModel->getTable();
    }

    public function create(array $data): Model
    {
        return $this->handleErrors(function () use ($data) {
            $model = $this->currentModel->create($this->extractMediaData($data));
            $this->handleMedia($model, $data);
            return $model;
        }, "Failed to create {$this->currentTable} record.");
    }

    public function update(int $id, array $data): Model
    {
        return $this->handleErrors(function () use ($id, $data) {
            $model = $this->currentModel->findOrFail($id);
            $model->update($this->extractMediaData($data));
            $this->handleMedia($model, $data, true);
            return $model;
        }, "Failed to update {$this->currentTable} record.");
    }

    public function delete(int $id)
    {
        return $this->handleErrors(function () use ($id) {
            $model = $this->currentModel->find($id);

            if (!$model) {
                return null; // record not found
            }

            // Check if model uses SoftDeletes
            if (in_array(SoftDeletes::class, class_uses_recursive($model))) {
                return $model->delete();   // soft delete
            }

            // Otherwise hard delete
            return $model->forceDelete();
        }, "Failed to delete {$this->currentTable} record.");
    }


    // public function delete(int $id)
    // {
    //     return $this->currentModel->destroy($id);
    // }

    public function findById(int $id, array $with = []): ?Model
    {
        // dd($id);
        return $this->handleErrors(function () use ($id, $with) {
            // dd($id);
            // dd($this->currentModel);
            return $this->currentModel->with($with)->findOrFail($id);
        }, "{$this->currentTable} record not found.");
    }

    public function all(array $with = []): Collection
    {
        return $this->handleErrors(fn() => $this->currentModel->with($with)->get());
    }

    public function findByName(string $name): ?Model
    {
        // dd($name);
        return $this->handleErrors(fn() => $this->currentModel->where('name', $name)->first());
    }
    public function syncOrDetachRelationship(Model $model, string $relation, array $ids, bool $sync = true): bool
    {
        return $this->handleErrors(function () use ($model, $relation, $ids, $sync) {
            if (!method_exists($model, $relation)) {
                throw new InvalidArgumentException("The relationship method {$relation} does not exist on the model.");
            }

            $relationship = $model->$relation();

            if (!$sync) {
                $relationship->detach($ids);
                return true;
            }

            $result = $relationship->sync($ids);

            return !empty($result['attached']) || !empty($result['detached']) || !empty($result['updated']);
        }, "Failed to sync or detach relationship '{$relation}'.");
    }

    // -----------------------------
    // Private helpers
    // -----------------------------
    private function extractMediaData(array &$data): array
    {
        unset($data['image'], $data['video']);
        return $data;
    }

    private function handleMedia(Model $model, array $data, bool $isUpdate = false): void
    {
        $images = $data['image'] ?? null;
        $video  = $data['video'] ?? null;

        if ($images) {
            $images = is_array($images) ? $images : [$images];
            foreach ($images as $image) {
                if ($image instanceof UploadedFile) {
                    $isUpdate
                        ? $this->updateMedia($model, $image, 'image')
                        : $this->attachMedia($model, $image, 'image');
                }
            }
        }

        if ($video instanceof UploadedFile) {
            $isUpdate
                ? $this->updateMedia($model, $video, 'video')
                : $this->attachMedia($model, $video, 'video');
        }
    }
}
