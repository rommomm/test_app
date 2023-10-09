<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model->get();
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(Model $entity, array $data): Model
    {
        $entity->update($data);
        return $entity;
    }

    public function delete(Model $entity): void
    {
        $entity->delete();
    }
}
