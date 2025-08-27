<?php
namespace App\Repositories;

use App\Models\Technology;
use Illuminate\Database\Eloquent\Collection;

class TechnologyRepository
{
    protected Technology $model;

    public function __construct(Technology $model)
    {
        $this->model = $model;
    }

    /**
     * Get all technologies
     */
    public function all(): Collection
    {
        return $this->model->all();
    }

    /**
     * Find a technology by ID
     */
    public function findById(int $id): ?Technology
    {
        return $this->model->find($id);
    }

    /**
     * Create a new technology
     */
    public function create(array $data): Technology
    {
        return $this->model->create($data);
    }

    /**
     * Update an existing technology
     */
    public function update(int $id, array $data): Technology
    {
        $technology = $this->model->findOrFail($id);
        $technology->update($data);
        return $technology;
    }

    /**
     * Delete a technology
     */
    public function delete(int $id): bool
    {
        $technology = $this->model->findOrFail($id);
        return $technology->delete();
    }
}
