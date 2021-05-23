<?php

namespace App\Services;

use App\Models\Financial;
use App\Models\Moviment;

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
}
