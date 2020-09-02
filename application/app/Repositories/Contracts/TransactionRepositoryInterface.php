<?php

namespace App\Repositories\Contracts;

use App\Models\Transaction;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface TransactionRepositoryInterface
{
    public function store(array $data): Transaction;

    public function paginate(int $perPage, int $page): LengthAwarePaginator;

    public function find(int $id): Transaction;

    public function destroy(int $id): bool;

    public function export(array $data): Collection;
}