<?php

namespace App\Services;

use App\Models\TransactionType;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;

class UserService
{
    private UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Regra de negócio para criar um novo usuário.
     *
     * @param array $data
     * @return User
     */
    public function store(array $data): User
    {
        $data['password'] = bcrypt($data['password']);
        return $this->userRepository->store($data);
    }

    /**
     * Regra de negócio para buscar todos os usuários.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->userRepository->all();
    }

    /**
     * Regra de negócio para buscar um determinado usuário.
     *
     * @param int $id
     * @return User
     */
    public function find(int $id): User
    {
        return $this->userRepository->find($id);
    }

    /**
     * Regra de negócio para deletar um determinado usuário
     *
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function destroy(int $id): bool
    {
        $user     = $this->balance($id);
        $credit   = isset($user['credit']) ? $user['credit'] : 0;
        $debit    = isset($user['debit']) ? $user['debit'] : 0;
        $reversal = isset($user['reversal']) ? $user['reversal'] : 0;
        $balance  = $credit + $reversal - $debit;
        if ($balance > 0) {
            throw new \Exception('Usuário não pode ser deletado porque existe saldo na conta.', 500);
        }
        if ($this->userRepository->hasTransactions($user)) {
            throw new \Exception('Usuário não pode ser deletado porque existem transações.', 500);
        }

        return $this->userRepository->destroy($user);
    }

    /**
     * Regra de negócio para atualizar informações de um determinado usuário
     * Essa regra poderá atualizar tanto um único campo quanto todos os campos
     * do usuário
     *
     * @param array $data
     * @param int $id
     * @return User
     */
    public function update(array $data, int $id): User
    {
        $user = $this->find($id);
        $this->userRepository->update($data, $user);

        return $this->find($id);
    }

    /**
     * Regra de negócio fazendo o balanço de todas as transações foram realizadas em um determinado usuário,
     * agrupando pelos tipos de transações.
     *
     * @param int $id
     * @return User
     */
    public function balance(int $id): User
    {
        $user         = $this->find($id);
        $transactions = $this->userRepository->transactionsGroupByType($user);

        foreach ($transactions as $type => $transaction) {
            $user[TransactionType::TYPE[$type]] = $transaction->sum('value');
        }

        unset($user['transactions']);

        return $user;
    }
}