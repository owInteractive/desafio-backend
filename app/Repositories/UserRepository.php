<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository extends AbstractRepository
{
  const RECORDS_PER_PAGE = 10;

  public function __construct(User $model)
  {
    $this->model = $model;
  }

  public function findAll()
  {
    return $this->model->orderBy('created_at', 'desc')->get();
  }

  public function getUserWithMovement(int $userId, int $page = 1)
  {
    return $this->model->where('id', $userId)
      ->with('movements', function($q) use ($page) {
        $q->limit(self::RECORDS_PER_PAGE)
          ->offset((self::RECORDS_PER_PAGE * $page) - self::RECORDS_PER_PAGE)
          ->with('movementType');
      })
      ->first();
  }

  public function getTotalBalance(int $userId)
  {
    $result = $this->model->with('movements')
      ->where('id', $userId)
      ->first();

    return $result->balance + $result->movements()->sum('value');
  }

  public function getByEmail($email)
  {
    return $this->model->where('email', $email)->first();
  }

}
