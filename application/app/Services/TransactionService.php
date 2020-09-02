<?php

namespace App\Services;

use App\Exports\TransactionsExport;
use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;

class TransactionService
{
    private TransactionRepositoryInterface $transactionRepository;

    public function __construct(TransactionRepositoryInterface $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Regra de negócio para criar uma nova transação.
     *
     * @param array $data
     * @return Transaction
     */
    public function store(array $data): Transaction
    {
        return $this->transactionRepository->store($data);
    }

    /**
     * Regra de negócio para buscar as transações
     *
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function paginate(array $data): LengthAwarePaginator
    {
        $perPage = array_key_exists('per_page', $data) ? $data['per_page'] : 15;
        $page = array_key_exists('page', $data) ? $data['page'] : 1;
        return $this->transactionRepository->paginate($perPage, $page);
    }

    /**
     * Regra de negócio responsável por excluir uma determinada transação
     *
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool
    {
        return $this->transactionRepository->destroy($id);
    }

    /**
     * Regra de negócio responsável por criar um excel de exportação e retorna o link de download para o usuário
     *
     * @param array $data
     * @return string
     */
    public function export(array $data): string
    {
        $name = "transactions-".time().".xlsx";
        $transactions = $this->transactionRepository->export($data);
        Excel::store(new TransactionsExport($transactions), $name, 'public');

        return Config::get('app.url')."storage/".$name;
    }
}