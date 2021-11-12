<?php

namespace App\Jobs;

use App\Method;
use App\Transaction;

class TransactionFactory
{
    public function createTransacation($data)
    {
        $transactionArray = [];
        foreach($data as $item){
            $name = Method::select('name')->where('id', $item->methods_id)->get();
            $transactionArray[] = new TransactionEntity($item->value, $name);
        }
        return $transactionArray;
    }


}
