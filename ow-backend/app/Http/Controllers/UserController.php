<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Movement;

class UserController extends Controller
{
    public function getAll() {
        $array = ['error' => ''];

        $users = User::orderBy('created_at', 'DESC')->get();

        if($users) {
            $array['users'] = $users;
        } else {
            $array['error'] = 'Nenhum usuário encontrado';
            return response()->json($array, 406);
        }

        return $array;
    }

    public function getUser($id) {
        $array = ['error' => ''];

        $user = User::find($id);

        if($user) {
            $array['user'] = $user;
        } else {
            $array['error'] = 'Este id não pertence a nenhum usuário';
            return response()->json($array ,406);
        }

        return $array;
    } 

    public function deleteUser ($id) {
     $array = ['error' => ''];
        
     $user = User::find($id);
     $moves = Movement::where('id_user', $id)->count();

     if($user && $moves <= 0 ) {

        User::where('id', $user['id'])->delete();

     } else {
         $array['error'] = 'Usuário com saldo ou movimentações não podem ser deletados!';
         return response()->json($array, 406);
     }

     return $array;
    }

    public function editBalance ($id, Request $request) {
        $array = ['error' => ''];

        $validator = Validator::make($request->all(), [
            'value' => 'required|numeric'
        ]);

        if(!$validator->fails()) {
            $value = $request->input('value');

            $user = User::find($id);

            if($user) {
                $user->balance = $value;
                $user->save();

                $array['message'] = 'Saldo alterado com sucesso!';
            }

        } else {
            $array['error'] = $validator->errors()->first();
            return $array;
        }       


        return $array;
    }
}
