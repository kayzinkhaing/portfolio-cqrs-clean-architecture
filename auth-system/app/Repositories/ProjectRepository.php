<?php
namespace App\Repositories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository
{
    protected Project $model;

    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function findById(int $id): ?Project
    {
        return $this->model->find($id);
    }

    public function create(array $data): Project
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Project
    {
        $project = $this->model->findOrFail($id);
        $project->update($data);
        return $project;
    }

    public function delete(int $id): bool
    {
        $project = $this->model->findOrFail($id);
        return $project->delete();
    }
}
