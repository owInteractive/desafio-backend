<?php

namespace App\Http\Controllers\Client;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function handle(RegisterRequest $request)
    {
        try {
            UserService::store($request);
            return Response::created(["message" => "Usuário criado com sucesso"]);
        } catch (\Throwable $th) {
            return Response::badRequest(["message" => "Erro ao criar usuário"]);
        }
    }
}
