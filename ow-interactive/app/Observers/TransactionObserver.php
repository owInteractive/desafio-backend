<?php

namespace App\Observers;

use App\Models\Transaction;
use App\Models\User;

class TransactionObserver
{
    /**
     * Handle the transaction "created" event.
     *
     * @param  App\Models\Transaction  $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $user = User::find($transaction->user_id);
        switch ($transaction->transaction_type_id)
        {
            case 1: // credito
                $user->current_amount += $transaction->value;
                $user->save();
                break;
            case 2: // debito
                $user->current_amount -= $transaction->value;
                $user->save();
                break;
            case 3: // estorno
                $user->current_amount += $transaction->value;
                $user->save();
                break;
        }
    }

    /**
     * Handle the transaction "deleted" event.
     *
     * @param  App\Models\Transaction  $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        $user = User::find($transaction->user_id);
        switch ($transaction->transaction_type_id)
        {
            case 1: // credito
                $user->current_amount -= $transaction->value;
                $user->save();
                break;
            case 2: // debito
                $user->current_amount += $transaction->value;
                $user->save();
                break;
            case 3: // estorno
                $user->current_amount -= $transaction->value;
                $user->save();
                break;
        }
    }
}
