<?php

namespace App\Services\Users;

use App\Models\User;
use App\Repositories\Users\UserRepositoryContract;
use App\Services\Users\UserServiceContract;
use Illuminate\Database\Eloquent\Collection;

class UserService implements UserServiceContract
{
    public function __construct(
        protected UserRepositoryContract $userRepository
    ) {  
    }
    
    public function listUsers(): Collection
    {
        return cache()->remember("users_list", 262800, function () {
            return $this->userRepository->listUsers();
        });
        
        return $this->userRepository->listUsers();
    }

    public function storeUser(array $request): User
    {
        cache()->forget("users_list");
        return $this->userRepository->storeUser($request);
    }

    public function getUser(int $id): User
    {
        return $this->userRepository->getUser($id);
    }

    public function destroyUser(int $id): Void
    {
        $this->userRepository->destroyUser($id);
    }

    public function saveOpeningBalance(int $id, array $request): User
    {
        $user = $this->userRepository->saveOpeningBalance($id, $request);

        return $user;
    }
}