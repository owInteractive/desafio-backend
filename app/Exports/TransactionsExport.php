<?php

namespace App\Exports;

use App\Http\Services\UserService;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;

class TransactionsExport implements FromArray
{
    private $transactions;
    private $fields;

    public function __construct($transactions, $fields)
    {
        $this->transactions = $transactions;
        $this->fields = $fields;
    }


    public function array(): array
    {
        $data = [
            $this->fields
        ];

        foreach ($this->transactions as $transaction){
            $user = app(UserService::class)->show($transaction->user_id);
            $row = $transaction->toArray();

            $row['created_at'] = new Carbon($row['created_at']);
            $row['created_at'] = $row['created_at']->format('d/m/Y');

            $row['updated_at'] = new Carbon($row['updated_at']);
            $row['updated_at'] = $row['updated_at']->format('d/m/Y');

            $row['user_name'] = $user->name;
            $row['user_birthday'] = $user->birthday;
            $row['user_email'] = $user->email;

            $row['user_balance'] = app(UserService::class)->getUserBalance($user->id);

            array_push($data,$row);
        }
        return $data;
    }
}

