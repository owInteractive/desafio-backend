<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use App\Models\Account;
use Illuminate\Http\Request;
use App\Http\Resources\Credit as CreditResource;
 
class CreditController extends Controller
{
    public function credito(Request $request)
    {   

        $credit = New Credit();
        $credit->valor_credito = $request->input('valor');
        $credit->account_id = $request->input('account_id');
        if($credit->valor_credito <= 0.00) {
            return response()->json([
                'message'   => 'Valor não pode ser menor ou igual a 0.00',
            ], 400);
        }
        
        /* Qaundo acontece uma movimentação de credito válida, é feito a busca da conta pelo ID e é
        incrementado o valor ao saldo da conta */

        $account = Account::find($credit->account_id);
        if (!is_null($account)) {
     
            if ($account->id == $credit->account_id) {

                $account->saldo += $credit->valor_credito;
                $account->save();
            }  
            
        }else {

            return response()->json([
                'message'   => 'Não existe conta cadastrado com este account_id',
            ], 400);       
        }

       
        if ($credit->save()) {
            return new CreditResource($credit);
        }   

    }

    
}
