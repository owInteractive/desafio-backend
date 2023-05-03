<?php

namespace App\Repositories\Transactions;

use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

class TransactionRepository implements TransactionRepositoryContract
{
    public function __construct(
        protected Transaction $model
    ) {  
    }

    public function store(array $request): Transaction
    {
        $transaction = new Transaction();
        $transaction->user_id = Arr::get($request,'user_id');
        $transaction->transaction_type_id = Arr::get($request,'transaction_type_id');
        $transaction->value = Arr::get($request,'value');
        $transaction->save();

        return $transaction;
    }

    public function get(int $userId, int $paginate): LengthAwarePaginator
    {
        return $this->model->where('user_id',$userId)->paginate($paginate);
    }

    public function destroy(int $id): Void
    {
        $user = $this->model->findOrFail($id);
        $user->delete();
    }

    public function export(int $userId, array $filters)
    {
        try 
        {
            $user = User::findOrFail($userId);

            if($filters['filter_type'] == 1) {
                $transactions = Transaction::where('user_id',$user->id)->whereDate('created_at', '>', Carbon::now()->subDays(30))->get();
            } else if($filters['filter_type'] == 2) {
                $date = explode('/', $filters['date_filter']);
                $transactions = Transaction::where('user_id',$user->id)->whereMonth('created_at', $date[0])->whereYear('created_at', $date[1])->get();
            } else {
                $transactions = Transaction::where('user_id',$user->id)->get();
            }

            $totalUser = $this->getTotalAmount($user);
            
            $columns = array('Id','Tipo Transação','Valor','Data');
            $fileCsv = function() use ($transactions,$user,$totalUser,$columns)
            {
                $file = fopen('php://output', 'w');

                if(!is_null($user)){
                fputcsv($file, array("nome", $user->name),';');
                fputcsv($file, array("email", $user->email),';');
                fputcsv($file, array("Saldo", $totalUser),';');
                }
                fputcsv($file,$columns,';');

                foreach($transactions as $transaction){
                fputcsv($file, array($transaction->id, $transaction->operationType->name, $transaction->amount, $transaction->created_at),';');
                }

                fclose($file);
            };
            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=file.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];
            
            return Response::stream($fileCsv, 200, $headers);
        }
        catch (Exception $e) 
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    private function getTotalAmount(User $user){
        $transactions = Transaction::where('user_id',$user->id)->get();

        if($transactions){
            $total = $user->opening_balance;
            foreach($transactions as $i => $transaction){
                if($transaction->operation_type_id == 1){
                    $total = $total + $transaction->value;
                }
                else if($transaction->operation_type_id == 2){
                    $total = $total - $transaction->value;
                }
                else if($transaction->operation_type_id == 3){
                    $total = $total + $transaction->amount;
                }
            }
            return $total;
        }else {
           return response()->json(['message' => 'Usuário não tem movimentação'], 404);
        }
    }
}