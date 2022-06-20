<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    public function unauthorized() {
        return response()->json([
            'error' => 'Não autorizado'
        ],401);
    }

    public function register(Request $request) {
        $array = ['error' => ''];

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'birthdate' => 'required|date|before:-18 years',
            'password' => 'required',
            'password_confirm' => 'required|same:password',
            
        ]);

        if(!$validator-> fails()) {
            $name = $request->input('name');
            $email = $request->input('email');
            $password = $request->input('password');
            $birthdate = $request->input('birthdate');

            // CRIANDO HASH PARA SALVAR SENHA NO DB
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $newUser = new User();
            $newUser->name = $name;
            $newUser->email = $email;
            $newUser->password = $hash;
            $newUser->birthdate = $birthdate;
            $newUser->save();

            $token = auth()->attempt([
                'email' => $email,
                'password' => $password
            ]);

            if(!$token) {
                $array['error'] = 'Ocorreu um erro.';
                return response()->json($array, 400);
            }

            $array['token'] = $token;

            $user = auth()->user();
            $array['user'] = $user;

        } else {
            $array['error'] = $validator->errors()->first();
            return response()->json($array, 406);
        }

        return $array;
    }

    public function login (Request $request) {
        $array = ['error' => ''];

        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(!$validator->fails()) {
            $email = $request->input('email');
            $password = $request->input('password');

            $token = auth()->attempt([
                'email' => $email,
                'password' => $password
            ]);

            if(!$token) {
                $array['error'] = 'E-Mail e/ou senha incorretos!';
                return response()->json($array, 406);
            }

            $array['token'] = $token;

            $user = auth()->user();
            $array['user'] = $user;

        } else {    
            $array['error'] = $validator->errors()->first();
            return response()->json($array, 406);
        }

        return $array;
    }
    
}
