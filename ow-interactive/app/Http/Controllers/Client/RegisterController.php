<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $user = new User();
            $user->fill($request->all());
            $user->password = Hash::make($user->password);
            $user->save();
            return response()->json(["message" => "Erro ao criar usuário"], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Erro ao criar usuário",], 400);
        }
    }
}
