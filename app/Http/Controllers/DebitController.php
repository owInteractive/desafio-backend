<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Debit;
use Illuminate\Http\Request;
use App\Http\Resources\Debit as DebitResource;


class DebitController extends Controller
{
    public function debito(Request $request)
    {   
        $debit = New Debit();
        $debit->valor_debito = $request->input('valor');
        $debit->account_id = $request->input('account_id');
        if($debit->valor_debito <= 0.00) {
            return response()->json([
                'message'   => 'Valor não pode ser menor ou igual a 0.00',
            ], 400);
        }

        /* Qaundo acontece uma movimentação de debito válida, é feito a busca da conta pelo ID e é
        decrementado o valor ao saldo da conta */

        $account = Account::find($debit->account_id);
        if (!is_null($account)) {
     
            if ($account->id == $debit->account_id) {

                $account->saldo -= $debit->valor_debito;
                $account->save();
            }  
            
        }else {

            return response()->json([
                'message'   => 'Não existe conta cadastrado com este account_id',
            ], 400);       
        }


        if($debit->save()){
            return new DebitResource($debit);
        }
    }

}
 
