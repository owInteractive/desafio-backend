<?php

namespace App\Http\Controllers;

use App\Models\Debit;
use App\Models\Reversal;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Http\Resources\Reversal as ReversalResource;
use App\Models\Credit;

class ReversalController extends Controller 
{
    public function estornoDebito(Request $request)
    {   
        // Pega os valores do request
        $reversal = new Reversal();
        $reversal->valor_estorno = $request->input('valor');
        $reversal->debit_id = $request->input('debit_id');
        $debit = Debit::find($reversal->debit_id);
        
        //verifica se existe algum debito na tabela debits com o id informado
        if (!is_null($debit)) {

            $reversal->account_id = $debit->account_id;

            //verifica se ja existe um estorno para o id informado
            $findReversal = Reversal::where('debit_id', $reversal->debit_id)->get();

            //Se não encontrar um registro de estorno para o id, executa todo o codigo
            if ($findReversal->isEmpty()){

                //verifica se o valor informado é menor ou igual a zero
                if($reversal->valor_estorno <= 0.00) {
                    return response()->json([
                        'message' => 'Valor não pode ser menor a igual a 0.00',
                    ], 400);
                }

                // compara se o valor informado é diferente do valor do debito a ser estornado
                if ($reversal->valor_estorno != $debit->valor_debito) {
                    return response()->json([
                        'message' => 'Erro, valor do estorno é diferente do debito',
                    ], 400);
                } else {
                    
                    // Assim que é feito o estorno do debito, é feito um credito no saldo e fica gravado a movimentação na tabela estorno
                    $account = Account::find($reversal->account_id);
                    $account->saldo += $reversal->valor_estorno;
                    $account->save();
                    if($reversal->save()){
                        return new ReversalResource($reversal);
                    }
                }


            } else {

                //Se existir um estorno com o id informado, retorna erro
                return response()->json([
                    'message'   => 'Erro, este débito ja foi estornado',
                ], 400); 
            }

        } else {
            //Se for informado um id que onde não existe debito a estonar, retorna erro
            return response()->json([
                'message'   => 'Não existe um debito para este ID',
            ], 400); 
        }

    }


    // Os mesmos comentarios acima, se aplicam na logica abaixo, a diferença é que ao nvés de debito é credito
    public function estornoCredito(Request $request)
    {
        $reversal = new Reversal();
        $reversal->valor_estorno = $request->input('valor');
        $reversal->credit_id = $request->input('credit_id');
        $credit = Credit::find($reversal->credit_id);

        if (!is_null($credit)) {
            $reversal->account_id = $credit->account_id;

            $findReversal = Reversal::where('credit_id', $reversal->credit_id)->get();

            if ($findReversal->isEmpty()){

                if($reversal->valor_estorno <= 0.00) {
                    return response()->json([
                        'message' => 'Valor não pode ser menor a igual a 0.00',
                    ], 400);
                }
                if ($reversal->valor_estorno != $credit->valor_credito) {
                    return response()->json([
                        'message' => 'Erro, valor do estorno é diferente do credito',
                    ], 400);
                } else {
                    // Assim que é feito o estorno do credito, é feito um débito no saldo e fica gravado a movimentação na tabela estorno
                    $account = Account::find($reversal->account_id);
                    $account->saldo -= $reversal->valor_estorno;
                    $account->save();
                    if($reversal->save()){
                        return new ReversalResource($reversal);
                    }
                }

            } else {
                
                return response()->json([
                    'message'   => 'Não existe um credito para este ID',
                ], 400); 
            }
        } else {

            return response()->json([
                'message'   => 'Erro, este credito ja foi estornado',
            ], 400); 
        }
    }

}

 

