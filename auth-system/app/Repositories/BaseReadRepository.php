<?php

namespace App\Repositories;

use App\Contracts\BaseReadInterface;
use MongoDB\Laravel\Eloquent\Model;

class BaseReadRepository implements BaseReadInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll(array $filters = [])
    {
        $query = $this->model->newQuery();

        foreach ($filters as $key => $value) {
            $query->where($key, $value);
        }

        return $query->get();
    }

    public function findById($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $record = $this->model->find($id);
        if ($record) {
            $record->update($data);
        }
        return $record;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }
}
