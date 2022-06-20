<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Repositories\User\UserRepository;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function __construct(
        private readonly UserRepository $repository
    ){}

    public function __invoke(LoginRequest $request)
    {
        $payload = $request->validated();

        $user = $this->repository->getByEmail($payload['email']);
        if(!$user || !Hash::check($payload['password'], $user->password)){
            return $this->responseApi([], 'Invalid email or password', 401);
        }

        $data = [
            'user' => $user,
            'token' => $user->createToken('')->plainTextToken,
        ];
        return $this->responseApi($data, 'valid credentials', 201);
    }
}
