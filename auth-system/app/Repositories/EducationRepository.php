<?php

namespace App\Repositories;

use App\Models\Education;

class EducationRepository
{
    protected $model;

    public function __construct(Education $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $education = $this->find($id);
        $education->update($data);
        return $education;
    }

    public function delete(int $id)
    {
        $education = $this->find($id);
        if ($education) {
            $education->delete();
        }
        return true;
    }
}
