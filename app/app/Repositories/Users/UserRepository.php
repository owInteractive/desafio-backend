<?php

namespace App\Repositories\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

class UserRepository implements UserRepositoryContract
{
    public function __construct(
        protected User $model
    ) {  
    }

    public function listUsers(): Collection
    {
        return $this->model->all()->sortByDesc('created_at');
    }

    public function storeUser(array $request): User
    {
        $user = new User();
        $user->name = Arr::get($request,'name');
        $user->email = Arr::get($request,'email');
        $user->birthday = Arr::get($request,'birthday');
        $user->password = bcrypt(Arr::get($request,'password'));
        $user->save();

        return $user;
    }

    public function getUser(int $id): User
    {
        return $this->model->findOrFail($id);
    }

    public function destroyUser(int $id): Void
    {
        $user = $this->model->findOrFail($id);
        $user->delete();
    }

    public function saveOpeningBalance(int $id, array $request): User
    {
        $user = $this->model->findOrFail($id);
        if ($user) {
            $user->opening_balance = Arr::get($request,'opening_balance');
            $user->save();
        }

        return $user;
    }
}