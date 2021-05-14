<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /** @var UserRepository */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function login(Request $request)
    {
        $this->validator($request->all(), [
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = $this->repository->getByEmail($request->get('email'));
        if ($user) {
            if (Hash::check($request->get('password'), $user->password)) {
                return response([
                    'token' => $user->api_token
                ]);
            } else {
                return response([
                    'message' => 'Senha inválida.'
                ], 422);
            }
        }

        return response([
            'message' => 'Nenhum usuário cadastrado com esse email'
        ], 404);
    }
}
