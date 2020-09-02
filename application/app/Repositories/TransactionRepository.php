<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class TransactionRepository implements TransactionRepositoryInterface
{
    private Transaction $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Armazena as informações de uma nova transação na base.
     *
     * @param array $data
     * @return Transaction
     */
    public function store(array $data): Transaction
    {
        return $this->transaction->create($data);
    }

    /**
     * Busca as informações de todas as transações.
     * Traz informações dos relacionamentos de usuários e tipo de transação
     *
     * @param int $perPage
     * @param int $page
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage, int $page): LengthAwarePaginator
    {
        return Cache::remember(
            "transactions$page$perPage",
            600,
            function () use ($perPage) {
                return $this->transaction
                    ->with(['user', 'type'])
                    ->IdDescending()
                    ->paginate($perPage);
            }
        );
    }

    /**
     * Busca uma determinada transação.
     *
     * @param int $id
     * @return Transaction
     */
    public function find(int $id): Transaction
    {
        return $this->transaction->findOrFail($id);
    }

    /**
     * Exclui uma determinada transação da base
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        $transaction = $this->find($id);

        return $transaction->destroy($id);
    }

    /**
     * Busca os dados para exportação com os parametros de filtros
     *
     * @param array $data
     * @return Collection
     */
    public function export(array $data): Collection
    {
        return $this->transaction->filter($data)->get();
    }
}