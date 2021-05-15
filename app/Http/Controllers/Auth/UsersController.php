<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SigUpRequest;
use App\Http\Requests\UsersRequest;

use App\Models\User;
use Auth;

class UsersController extends Controller
{
    public function store(SigUpRequest $request) { 
        try {
            $dados = $request->all();

            $dados['password'] = bcrypt($request['password']);  

            $user = User::create($dados);
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;

            $data = ['token' => $token, 'user'=>$user]; 

            $response = [
                'data' => $data,
                'success' => true
            ];
            $status = 200;

        } catch (\Throwable $th) {

            $response = [
                'error'=>$th->getMessage(),
                'success' => false
            ];
            $status = 500;
        }
        
        return response($response,$status); 
	}

    //Retornar dados o user logado
	public function profile(Request $request){
        try {
            $user = Auth::user();  
            $response = ['data' => $user];
            $status = 200;

        }catch (\Throwable $th) {

            $response = [
                'error'=>$th->getMessage(),
                'success' => false
            ];
            $status = 500;
        }
        
        return response($response,$status);  
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersRequest $request)
    {
        try {
            $data = $request->all();
            $user = $request->user();

            if(!empty($request->password)){
                $user->password = bcrypt($request['password']); 
            }

            $user->update($data);

            $response = [
                'data' => $user,
                'success' => true
            ];
            $status = 200;

        } catch (\Throwable $th) {

            $response = [
                'error'=>$th->getMessage(),
                'success' => false
            ];
            $status = 500;
        }
        
        return response($response,$status); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try { 
            $user = $request->user();     
            
            /*
             * Check if user has movements
             */
            if($user->movements()->count()){
                throw new \Exception("Este usuário possui movimentações e não pode ser deletado");
            }

            $user->delete();

            $response = [
                'success' => true
            ];
            $status = 200;

        } catch (\Throwable $th) {

            $response = [
                'error'=>$th->getMessage(),
                'success' => false
            ];
            $status = 500;
        }
        
        return response($response,$status);
    } 

}
