<?php

namespace App\Repositories;

use App\Exports\TransactionsExport;
use App\Models\Transaction;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class TransactionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'transaction_type_id',
        'value'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Transaction::class;
    }

    /**
     * @param array $input
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create($input)
    {
        $model = parent::create($input);
        return $model;
    }

    /**
     * @param array $filters
     * @return string[]
     */
    public function export(array $filters)
    {
        if($filters['filter_type'] == 1) {
            $transactions = Transaction::whereDate('created_at', '>', Carbon::now()->subDays(30))->get();
        } else if($filters['filter_type'] == 2) {
            $date = explode('/', $filters['date_filter']);
            $transactions = Transaction::whereMonth('created_at', $date[0])->whereYear('created_at', $date[1])->get();
        } else {
            $transactions = Transaction::get();
        }

        # process spreeadsheat
        $arquivo = 'transactions-'.date('d.m.Y_His').'.csv';
        Excel::store(new TransactionsExport($transactions), $arquivo, 'public');

        return ['link' => config('app.url')."/storage/".$arquivo];
    }
}
