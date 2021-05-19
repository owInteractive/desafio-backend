<?php

namespace App\Http\Controllers;

use App\Models\Debit;
use App\Models\Reversal;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Parent_;
use App\Http\Controllers\DebitController;

class ReversalController extends Controller DebitController
{
    public function estornoDebito(Request $request)
    {
        $estorno = new Reversal();
        $estorno->valor = $request->input('valor');
        $estorno->id_debit = $request->input('id_debit');

        if($estorno->valor <= 0.00) {
            return response()->json([
                'message' => 'Valor não pode ser menor a igual a 0.00',
            ], 400);
        }

        $debit = Debit::find($estorno->id_debit);

        if ($estorno->valor > $debit->valor) {
            return response()->json([
                'message' => 'Erro, valor do estorno é maior do que o debito',
            ], 400);
        } else {
            $debit->debito($estorno->id_debit);
        }

        $debit->valor = $estorno->valor;

        $estorno->save();

    }

    public function estornoCredito(Request $request)
    {
        $estorno = new Reversal();
        $estorno->valor = $request->input('valor');
        $estorno->id_credit = $request->input('id_credit');
        $estorno->save();
    }
}
