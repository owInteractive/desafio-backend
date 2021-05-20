<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Credit;
use App\Models\Debit;
use App\Models\Reversal;
use Illuminate\Http\Request;


class MoveDeleteController extends Controller
{
    public function excluirMovimentacao(Request $request)
    {
        $move = $request->input('nome_movimentação');
        $id = $request->input('id_movimentação');

        switch ($move) {
            case 'credito':
               $this->excluirCredito($id);
                break;
            case 'debito':
                $this->excluirDebito($id);
                break;
            case 'estorno':
                $this->excluirEstorno($id);
                break;

        }
    }

    public function excluirCredito($id)
    {
        //procura o id informado e retorna o id da conta cujo o debito foi vinculado
        $credit = Credit::find($id);
        if (!is_null($credit)) {
            
            // $credit->account_id;
            
            //procura o id do debito dentro da conta para decrementar o saldo
            $account = Account::where('id', $credit->account_id)->get();
            foreach ($account as $acc) {
                $acc->saldo -= $credit->valor_credito;
            }
            $acc->save();

            $credit->delete();

        } else {
            return response()->json([
                'message'   => 'Não existe esta movimentação para este ID',
            ], 400);
        }

        //     return response()->json([
        //         'message'   => 'Movimentação excluida com sucesso',
        //     ], 200);

           
        // } else {
        //     return response()->json([
        //         'message'   => 'Não existe esta movimentação para este ID',
        //     ], 400);
        // }


    }

    public function excluirDebito($id)
    {
        //procura o id informado e retorna o id da conta cujo o debito foi vinculado
        $debit = Debit::find($id);
        if (!is_null($debit)) {
            
            // $debit->account_id;
            
            //procura o id do debito dentro da conta para incrementa o saldo
            $account = Account::where('id', $debit->account_id)->get();
            foreach ($account as $acc) {
                $acc->saldo += $debit->valor_debito;
            }
            $acc->save();

            $debit->delete();

        } else {
            return response()->json([
                'message'   => 'Não existe esta movimentação para este ID',
            ], 400);

        }
    }
    

    public function excluirEstorno($id)
    {
        //procura o id informado e retorna o id da conta cujo o debito foi vinculado
        $reversal = Reversal::find($id);
        if (!is_null($reversal)) {
   

            if (!is_null($reversal->debit_id)) {
                
                //procura o id do debito referente ao estorno
                $debits = Debit::where('id', $reversal->debit_id)->get();
                foreach ($debits as $debit) {
                
                //com o id do credito, procura essa movimentação na conta para fazer o descremento no saldo
                $account = Account::find($debit->account_id);
                $account->saldo += $reversal->valor_estorno;
                $account->save();
                }

                $reversal->delete();


            }

            if (!is_null($reversal->credit_id)) {

                //procura o id do credito referente ao estorno
                $credits = Credit::where('id', $reversal->credit_id)->get();
                foreach ($credits as $credit) {

                    //com o id do credito, procura essa movimentação na conta para fazer o descremento no saldo
                    $account = Account::find($credit->account_id);
                    $account->saldo -= $reversal->valor_estorno;
                    $account->save();
                }

                $reversal->delete();


            }
            
        } else {
            return response()->json([
                'message'   => 'Não existe esta movimentação para este ID',
            ], 400);
        } 

    }

   


}
