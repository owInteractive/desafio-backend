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
        $credit->valor = $request->input('valor');
        $credit->account_id = $request->input('account_id');
        if($credit->valor <= 0.00) {
            return response()->json([
                'message'   => 'Valor não pode ser menor a igual a 0.00',
            ], 400);
        }
        
        /* Qaundo acontece uma movimentação de credito válida, é feito a busca da conta pelo ID e é
        incrementado o valor ao saldo da conta */
        $accountFinds = Account::find($request->input('account_id'));
        if (!is_null($accountFinds)) {
     
            $accountFinds = Account::where('id', $request->input('account_id'))->get();
            foreach ($accountFinds as $accountFind ) {
                if ($accountFind->id == $request->input('account_id')) {
    
                    $accountFind->saldo = $request->input('valor');
                    $accountFind->save();
    
                }  
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
