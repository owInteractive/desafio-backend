<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    public function store(array $data): User;

    public function all(): Collection;

    public function find(int $id): User;

    public function destroy(User $user): bool;

    public function update(array $data, User $user): bool;

    public function transactionsGroupByType(User $user): Collection;

    public function hasTransactions(User $user): bool;
}