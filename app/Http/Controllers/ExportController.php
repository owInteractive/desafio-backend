<?php

namespace App\Http\Controllers;

use App\Transaction;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;


class ExportController
{

    public function last($id ,$month, $year)
    {

        $user = User::find($id);

        $date = new DateTime();
        $date->setDate($year, $month, 30);
        $now = $date->format('Y-m-d H:i:s');

        $dateSub = new DateTime();
        $dateSub->setDate($year, $month, 1);
        $sub = $dateSub->format('Y-m-d H:i:s');


        $fileName = 'transactions.csv';
        $transactions = Transaction::where('created_at', '>' ,$sub)->orWhere('created_at', '<', $now)->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('id', 'user_id', 'methods_id', 'value', 'name', 'balance');

        $callback = function() use($user, $transactions, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            $row['name'] = $user->name;
            $row['balance'] = $user->balance;
            foreach ($transactions as $transaction) {

                $row['id']  = $transaction->id;
                $row['user_id']    = $transaction->user_id;
                $row['methods_id']    = $transaction->methods_id;
                $row['value']  = $transaction->value;
                fputcsv($file, array($row['id'], $row['user_id'], $row['methods_id'], $row['value'], $row['name'], $row['balance']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);


    }
}
