<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Exceptions\DeletUserNotPermittedExpection;
use App\Http\Controllers\Exceptions\UserNotFoundException;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /** @var UserRepository */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->findAll();
    }

    public function getById($id)
    {
        $user = $this->repository->find($id);
        if (!$user) {
            throw new UserNotFoundException;
        }

        return $user;
    }

    public function create(Request $request)
    {
        $this->validator($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password' => 'required',
            'birthday' => 'required|date_format:d/m/Y|before:-18 anos',
        ]);

        return $this->repository->create($request->toArray());
    }

    public function delete($id)
    {
        $user = $this->repository->find($id);
        if (!$user) {
            throw new UserNotFoundException;
        }

        if ($user->movements()->count() > 0 || $user->balance > 0) {
            throw new DeletUserNotPermittedExpection;
        }

        $this->repository->delete($user);
        return response([
            "message" => "Usuário removido com sucesso!"
        ]);
    }

    public function getMovement(Request $request)
    {
        $userWithMovement = $this->repository->getUserWithMovement(
            $request->user()->id, $request->page ?? 1
        );

        return $userWithMovement;
    }

    public function updateBalance(Request $request)
    {
        $this->validator($request->all(), [
            'value' => 'required|numeric'
        ]);

        $user = $this->repository->find($request->user()->id);
        $user->balance = $request->get('value');

        $this->repository->update($user);

        return [
            "message" => "Saldo atualizado com sucesso!"
        ];
    }

    public function balanceTotal(Request $request)
    {
        $result = $this->repository->getTotalBalance(
            $request->user()->id
        );

        return [
            "total" => $result
        ];
    }
}
