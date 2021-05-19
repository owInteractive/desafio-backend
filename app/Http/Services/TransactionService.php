<?php


namespace App\Http\Services;


use App\Exports\TransactionsExport;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Carbon\Traits\Creator;
use Maatwebsite\Excel\Excel;

class TransactionService
{
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository){
        $this->transactionRepository = $transactionRepository;
    }

    public function index(){

        return $this->transactionRepository;
    }

    public function create(array $data){
        return $this->transactionRepository->create($data);
    }

    public function show($id){
        return $this->transactionRepository->getById($id);
    }

    public function destroy($id){
        return $this->transactionRepository->destroy($id);
    }

    public function export(array $filter = []){


        $transactionRepository = app(TransactionRepository::class);

        if(array_key_exists('monthAndYear',$filter)) {
            $transactionRepository->fromMonthAndYear($filter['monthAndYear']);
        }

        if (array_key_exists('last30Days',$filter)) {
            $fromDate = Carbon::now()->subDays(30);
            $tilLDate = Carbon::now();
            $transactionRepository->fromDate($fromDate->format('Y-m-d'));
            $transactionRepository->tillDate($tilLDate->format('Y-m-d'));
        }

        $fields = ['id', 'amount', 'transaction_type', 'user_id', 'created_at','updated_at','user_name','user_birthday','user_email','user_balance'];



        $transactionRepository->model = $transactionRepository->model->orderByDesc('created_at');
        $transactions = $transactionRepository->model->get();


        $export = new TransactionsExport($transactions, $fields);
        $excel = app(Excel::class);

        return $excel->download($export, 'export.csv', \Maatwebsite\Excel\Excel::CSV, ['Content-Type' => 'text/csv',]);
    }

    public function sumUserTransactions($id){
        app(UserService::class)->show($id);
        return  $this->transactionRepository->model->where('user_id',$id)->sum('amount')/100;
    }


}
