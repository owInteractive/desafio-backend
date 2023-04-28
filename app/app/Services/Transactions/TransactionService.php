<?php

namespace App\Services\Transactions;

use App\Models\Transaction;
use App\Repositories\Transactions\TransactionRepositoryContract;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TransactionService implements TransactionServiceContract
{
    public function __construct(
        protected TransactionRepositoryContract $transactionRepository
    ) {  
    }
    
    public function store(array $request): Transaction
    {
        return $this->transactionRepository->store($request);
    }

    public function get(int $userId, int $paginate): LengthAwarePaginator
    {
        return $this->transactionRepository->get($userId, $paginate);
    }

    public function destroy(int $id): Void
    {
        $this->transactionRepository->destroy($id);
    }

    public function export(int $id, array $request)
    {
        $user = $this->transactionRepository->export($id, $request);

        return $user;
    }
}