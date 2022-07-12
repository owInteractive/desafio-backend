<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionsExport implements FromView
{
    private $transactions;

    /**
     * TransactionsExport constructor.
     * @param Collection $transactions
     */
    public function __construct(Collection $transactions)
    {
        $this->transactions = $transactions;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('transactions.excel', [
            'transactions' => $this->transactions
        ]);
    }
}
