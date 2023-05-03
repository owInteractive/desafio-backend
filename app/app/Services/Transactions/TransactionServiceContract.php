<?php

namespace App\Services\Transactions;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TransactionServiceContract
{
    public function store(array $request): Transaction;

    public function get(int $userId, int $paginate): LengthAwarePaginator;

    public function destroy(int $id): Void;

    public function export(int $id, array $request);
}