<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class UserRepository implements UserRepositoryInterface
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Armazena as informações de um novo usuário na base.
     *
     * @param array $data
     * @return User
     */
    public function store(array $data): User
    {
        return $this->user->create($data);
    }

    /**
     * Busca todos os usuários armazenados na base de ordem descendente pelo ID.
     *
     * @return Collection
     */
    public function all(): Collection
    {
        return Cache::remember('users', 600, function() {
           return $this->user->idDescending()->get();
        });
    }

    /**
     * Busca um determinado usuário, caso não encontre retorna uma exceção do tipo ModelNotFoundException
     *
     * @param int $id
     * @return User
     */
    public function find(int $id): User
    {
        return $this->user->findOrFail($id);
    }

    /**
     * Deleta um determinado usuário da base
     *
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function destroy(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Atualiza as informações de um determinado usuário
     *
     * @param array $data
     * @param User $user
     * @return bool
     */
    public function update(array $data, User $user): bool
    {
        return $user->update($data);
    }

    /**
     * Busca todas as transações de um determinado usuário agrupando por tipo da transação.
     *
     * @param User $user
     * @return Collection
     */
    public function transactionsGroupByType(User $user): Collection
    {
        return $user->transactions->groupBy('transaction_type_id');
    }

    /**
     * Verificar se existe alguma transação no usuário
     *
     * @param User $user
     * @return bool
     */
    public function hasTransactions(User $user): bool
    {
        return $user->transactions()->exists();
    }
}