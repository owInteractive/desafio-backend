<?php

namespace App\Observers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Redis;

class TransactionObserver
{
    /**
     * Handle the transaction "created" event.
     *
     * @param \App\Models\Transaction $transaction
     * @return void
     */
    public function created(Transaction $transaction)
    {
        $transactions = Redis::keys(config('cache.prefix') . ':transactions*');
        if (!empty($transactions)) {
            Redis::del($transactions);
        }
    }

    /**
     * Handle the transaction "updated" event.
     *
     * @param \App\Models\Transaction $transaction
     * @return void
     */
    public function updated(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the transaction "deleted" event.
     *
     * @param \App\Models\Transaction $transaction
     * @return void
     */
    public function deleted(Transaction $transaction)
    {
        $transactions = Redis::keys(config('cache.prefix') . ':transactions*');
        if (!empty($transactions)) {
            Redis::del($transactions);
        }
    }

    /**
     * Handle the transaction "restored" event.
     *
     * @param \App\Models\Transaction $transaction
     * @return void
     */
    public function restored(Transaction $transaction)
    {
        //
    }

    /**
     * Handle the transaction "force deleted" event.
     *
     * @param \App\Models\Transaction $transaction
     * @return void
     */
    public function forceDeleted(Transaction $transaction)
    {
        //
    }
}
