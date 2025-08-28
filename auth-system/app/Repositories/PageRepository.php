<?php

namespace App\Repositories;

use App\Models\Page;

class PageRepository
{
    protected Page $model;

    public function __construct(Page $page)
    {
        $this->model = $page;
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
        $page = $this->find($id);
        $page->update($data);
        return $page;
    }

    public function delete(int $id)
    {
        $page = $this->find($id);
        return $page->delete();
    }
}
