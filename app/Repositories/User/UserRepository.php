<?php

namespace App\Repositories\User;

use App\Models\Movement;
use App\Models\User;
use App\Repositories\Movement\Enums\MovementType;

class UserRepository
{
    public function __construct(
        private readonly User $model,
        private readonly Movement $modelMovement
    ){}

    public function store($payload)
    {
        return $this->model->create($payload);
    }

    public function getAll()
    {
        return $this->model->orderBy('id', 'DESC')->get();
    }

    public function getByEmail($email)
    {
        return $this->model->whereEmail($email)->firstOrFail();
    }

    public function getOne($id)
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id): ?bool
    {
        $user = $this->getOne($id);
        return $user->delete();
    }

    public function changeBalance($id, $payload)
    {
        $user = $this->getOne($id);
        $user->opening_balance = $payload['value'];
        $user->save();
        return $user;
    }

    public function balance($id)
    {
        $user = $this->getOne($id);
        $debit = $this->modelMovement->whereUserId($id)->whereType(MovementType::debit->value)->sum('value');
        $credit = $this->modelMovement->whereUserId($id)->whereType(MovementType::credit->value)->sum('value');
        $reversal = $this->modelMovement->whereUserId($id)->whereType(MovementType::reversal->value)->sum('value');
        return [
            'user_id' => $user->id,
            'name' => $user->name,
            'balance' => [
                'opening_balance' => number_format($user->opening_balance, 2 , '.'),
                'debit' => number_format($debit, 2 , '.'),
                'credit' => number_format($credit, 2 , '.'),
                'reversal' => number_format($reversal, 2 , '.'),
            ]
        ];
    }
}
