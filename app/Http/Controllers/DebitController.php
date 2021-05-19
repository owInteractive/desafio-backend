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
        $debit->valor = $request->input('valor');
        $debit->account_id = $request->input('account_id');
        if($debit->valor <= 0.00) {
            return response()->json([
                'message'   => 'Valor não pode ser menor a igual a 0.00',
            ], 400);
        }

        $account = Account::find($debit->account_id);
        if($debit->valor > $account->saldo) {
            return response()->json([
                'message'   => 'Saldo insuficiente para a operação',
            ], 400);
        } else {
        /* Qaundo acontece uma movimentação de debito válida, é feito a busca da conta pelo ID e é
        decrementado o valor ao saldo da conta */
            $account->saldo = $account->saldo - $debit->valor;
            $account->save();
            if($debit->save()){
                return new DebitResource($debit);
            }
        }

    }
}
