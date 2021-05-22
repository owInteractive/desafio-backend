<?php

namespace App\Http\Controllers\Client;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function handle(RegisterRequest $request)
    {
        try {
            $user = new User();
            $user->fill($request->all());
            $user->password = Hash::make($user->password);
            $user->save();
            return Response::created(["message" => "Usuário criado com sucesso"]);
        } catch (\Throwable $th) {
            return Response::badRequest(["message" => "Erro ao criar usuário"]);
        }
    }
}
