<?php

namespace App\Http\Controllers;

 
use Illuminate\Http\Request;
use App\Http\Resources\Account as AccountResource;
use App\Models\Account;
use App\Models\User;

class AccountController extends Controller
{
    public function saldo()
    {
        
    }


    public function criarConta(Request $request)
    {
        $account = New Account();
        $account->user_id = $request->input('user_id');        
        // $accountFinds = Account::where('user_id', $account->user_id)->get();

        $user = User::find($account->user_id);
      
        if (is_null($user)) {
            return response()->json([
                'message'   => 'Usuário não cadastrado para se criar uma conta',
            ], 400);
        }
        

        $accountFinds = Account::where('user_id', $account->user_id)->get();
        foreach ($accountFinds as $accountFind) {
   
            if ($accountFind->user_id == $account->user_id) {

                return response()->json([
                    'message'   => 'Este Usuário ja tem uma conta'
                ], 400);
            }
        }

        $account->save(); 
        return new AccountResource($account);
         
    }
}
