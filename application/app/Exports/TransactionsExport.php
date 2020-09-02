<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionsExport implements FromView
{
    private Collection $transactions;

    public function __construct(Collection $transactions)
    {
        $this->transactions = $transactions;
    }

    public function view(): View
    {
        return view('exports.excel', [
            'transactions' => $this->transactions
        ]);
    }
}
