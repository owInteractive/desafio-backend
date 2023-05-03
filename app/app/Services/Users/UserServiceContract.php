<?php

namespace App\Services\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserServiceContract
{
    public function listUsers(): Collection;

    public function storeUser(array $request): User;

    public function getUser(int $id): User;

    public function destroyUser(int $id): Void;

    public function saveOpeningBalance(int $id, array $request): User;
}