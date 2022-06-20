<?php

namespace App\Repositories\Movement;

use App\Repositories\Movement\Filters\LastThirtyDaysFilter;
use App\Models\Movement;
use App\Repositories\Movement\Enums\MovementType;
use App\Repositories\Movement\Filters\MonthFilter;
use Illuminate\Pipeline\Pipeline;

class MovementRepository
{
    public function __construct(
        private readonly Movement $model
    ){}

    public function store($payload)
    {
        $data = [
            'user_id' => $payload['user_id'],
            'type' => MovementType::type($payload['type']),
            'value' => $payload['value'],
        ];
        return $this->model->create($data);
    }

    public function getByUserId($userId)
    {
        $query = $this->model->query();
        if(request()->has('all') AND request()->input('all')===false){
            $query = app(Pipeline::class)
                ->send($query)
                ->through([
                    LastThirtyDaysFilter::class,
                    MonthFilter::class,
                ])
                ->thenReturn();
        }
        return $query->whereUserId($userId)->get();
    }

    public function getByUserIdWithPaginate($userId, $limit)
    {
        return $this->model->whereUserId($userId)->paginate($limit);
    }

    public function delete($id, $userId): ?bool
    {
        $user = $this->model->whereId($id)->whereUserId($userId)->first();
        return $user->delete();
    }
}
