<?php

namespace App\Services;

use App\Models\Financial;
use App\Models\Moviment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

class FinancialService
{
    static function recalcBalance(Financial $financial)
    {
        $allMoviments = Moviment::where('financial_id', $financial->id)
            ->get(['moviment_type_id', 'value']);

        $allMovimentValues = $allMoviments->sum('value');
        $debitMovimentValue = $allMoviments->where('moviment_type_id', 1)->sum('value');
        $openingBalance = $financial->opening_balance;

        $currentBalance = ($openingBalance + $allMovimentValues) - $debitMovimentValue;
        $financial->current_balance = $currentBalance;
        $financial->save();

        return $financial;
    }

    public static function balance($userId)
    {
        return Financial::select('opening_balance', 'current_balance')
            ->where('user_id', $userId)->first();
    }

    public static function changeOpeningBalance($request, $userId)
    {
        DB::beginTransaction();

        try {
            $financial = Financial::where('user_id', $userId)->first();
            $financial->opening_balance = $request->opening_balance;
            self::recalcBalance($financial);
            DB::commit();
            return true;
        } catch (ModelNotFoundException $th) {
            DB::rollback();
            throw $th;
        }
    }
}
