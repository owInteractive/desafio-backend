<?php

namespace App\Repositories;

use App\Models\Movement;
use Carbon\Carbon;

class MovementRepository extends AbstractRepository {

  public function __construct(Movement $model) {
    $this->model = $model;
  }

  public function getMovementToReversal($userId, $movementId)
  {
    return $this->model->where('user_id', $userId)
      ->where('id', $movementId)
      ->whereNull('parent_id')
      ->first();
  }

  public function getLast30Days(int $userId)
  {
    return $this->model->where('user_id', $userId)
      ->where('created_at', '>', Carbon::now()->subDays(30))
      ->with('movementType')
      ->with('user')
      ->get();
  }

  public function getByDate(int $userId, string $date) {
    $date = explode("_", $date);

    return $this->model->where('user_id', $userId)
      ->whereMonth('created_at', '=', $date[0])
      ->whereYear('created_at', '=', $date[1])
      ->with('movementType')
      ->with('user')
      ->get();
  }

  public function getByUser(int $userId)
  {
    return $this->model->where('user_id', $userId)
      ->with('movementType')
      ->with('user')
      ->get();
  }

}
