<?php

namespace App\Repositories;

use App\Models\Experience;

class ExperienceRepository
{
    protected Experience $model;

    public function __construct()
    {
        $this->model = new Experience();
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $experience = $this->find($id);
        $experience->update($data);
        return $experience;
    }

    public function delete(int $id)
    {
        $experience = $this->find($id);
        return $experience->delete();
    }
}
