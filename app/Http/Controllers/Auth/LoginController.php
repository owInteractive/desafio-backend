<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SigInRequest;

use App\Models\User;
use Hash;

class LoginController extends Controller
{
    public function store(SigInRequest $request) {
        try { 
            $user = User::where('email', $request->email)->first();
 
            if (!$user) {
                throw new \Exception("Usuário não localizado");
            } 
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;

                $dados = [
                    'name' => $user->name,
                    'email' => $user->email, 
                    'token' => $token,
                ];     
                $response = [
                    'data' => $dados,
                    'success' => true
                ];
                $status = 200;

            }else{ 
                throw new \Exception("Email e senha não conferem"); 
            }

        } catch (\Throwable $th) {

            $response = [
                'error'=>$th->getMessage(),
                'success' => false
            ];
            $status = 500;
        }
        
        return response($response,$status);               
    }

    // //Função logout
	public function destroy(Request $request) {
	    $token = $request->user()->token();
	    $token->revoke();

	   	$response = ['data' => array(
	    	'message'=> 'Logout realizado com sucesso',
	    )];

	    return response($response, 200);
	}
}
