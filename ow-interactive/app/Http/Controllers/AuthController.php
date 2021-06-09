<?php

namespace App\Http\Controllers;

use App\Helpers\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return Response::unauthorized();
        }

        return $this->respondWithToken($token);
    }

    public function logout()
    {
        Auth::logout();

        return Response::success(['message' => 'Logout realizado com sucesso.']);
    }

    protected function respondWithToken($token)
    {
        return Response::success([
            'message' => "Bem vindo",
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60
        ]);
    }
}
