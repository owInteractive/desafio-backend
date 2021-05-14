<?php

namespace App\Repositories;

abstract class AbstractRepository
{
  /**
   * @var \Illuminate\Database\Eloquent\Model
   */
  protected $model;

  public function find($id)
  {
    return $this->model->find($id);
  }

  public function findAll()
  {
    return $this->model->all();
  }

  public function create(array $data)
  {
    return $this->model->create($data);
  }

  public function delete($record)
  {
    return $record->delete();
  }

  public function update($record)
  {
    return $record->save();
  }

  public function paginate($pages)
  {
    return $this->model->paginate($pages);
  }
}
