<?php

namespace App\Repositories;

use App\Contracts\BaseInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Traits\Media;

class BaseRepository implements BaseInterface
{
    public Model $currentModel;
    protected $currentTable;
    protected $data;
    use Media;

    public function __construct(string $modelName)
    {
        if (!empty($modelName)) {
            $this->currentModel = app("App\\Models\\{$modelName}");
            $this->currentTable = $this->currentModel->getTable();
        }
    }

    public function create(array $data)
    {
        $images = $data['image'] ?? null;
        $video = $data['video'] ?? null;

        unset($data['image'], $data['video']);
        // dd($this->currentModel);

        $model = $this->currentModel->create($data);

        if (is_array($images)) {
            foreach ($images as $image) {
                if ($image instanceof \Illuminate\Http\UploadedFile) {
                    $this->attachMedia($model, $image, 'image');
                }
            }
        } elseif ($images instanceof \Illuminate\Http\UploadedFile) {
            $this->attachMedia($model, $images, 'image');
        }

        if ($video instanceof \Illuminate\Http\UploadedFile) {
            $this->attachMedia($model, $video, 'video');
        }

        return $model;
    }

    public function update(int $id, array $data)
    {
        // dd($data);
        $images = $data['image'] ?? null;
        $video = $data['video'] ?? null;

        unset($data['image'], $data['video']);
        // dd($data);
        $model = $this->currentModel->find($id);
        $model->update($data);
        if (is_array($images)) {
            foreach ($images as $image) {
                if ($image instanceof \Illuminate\Http\UploadedFile) {
                    $this->updateMedia($model, $image, 'image');
                }
            }
        } elseif ($images instanceof \Illuminate\Http\UploadedFile) {
            $this->updateMedia($model, $images, 'image');
        }

        if ($video instanceof \Illuminate\Http\UploadedFile) {
            $this->updateMedia($model, $video, 'video');
        }

        return $model;
    }

    public function delete(int $id)
    {
        return $this->currentModel->destroy($id);
    }

    // Get all records with optional eager loading
    public function all(array $with = []): Collection
    {
        return $this->currentModel->with($with)->get();
    }

    // Additional common methods like find, create, etc.
    public function findById($id, array $with = []): ?Model
    {
        // dd($id);
        // dd($with);
        // dd($this->currentModel->getTable());
        // dd($this->currentModel->with($with)->find($id));
        return $this->currentModel->with($with)->find($id);
    }

    public function findByName($name)
    {
        return $this->currentModel->where('name', $name)->first();
    }

    public function syncOrDetachRelationship(Model $model, string $relation, array $ids, bool $sync = true): bool
    {
        // Check if the relationship method exists
        if (!method_exists($model, $relation)) {
            throw new \InvalidArgumentException("The relationship method {$relation} does not exist on the model.");
        }

        // Get the relationship method on the model
        $relationship = $model->$relation();
        // Perform sync or detach based on the flag
        if (!$sync) {
            // Detach the relationship and return true if successful
            $relationship->detach($ids);
            return true;
        }
        // Sync the relationship and check if anything was attached/detached
        $result = $relationship->sync($ids);

        // If there are any changes (attached, detached, or updated), return true
        return isset($result['attached']) || isset($result['detached']) || isset($result['updated']);
    }
}
