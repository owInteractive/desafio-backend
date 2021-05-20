<?php

namespace App\Http\Controllers;

 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Account as AccountResource;
use App\Models\Account;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CsvExport;


class AccountController extends Controller
{
    public function criarConta(Request $request)
    {
        $account = New Account();
        $account->user_id = $request->input('user_id');        
        // $accountFinds = Account::where('user_id', $account->user_id)->get();

        $user = User::find($account->user_id);
      
        if (is_null($user)) {
            return response()->json([
                'message'   => 'Usuário não cadastrado para se criar uma conta',
            ], 400);
        }
        

        $accountFinds = Account::where('user_id', $account->user_id)->get();
        foreach ($accountFinds as $accountFind) {
   
            if ($accountFind->user_id == $account->user_id) {

                return response()->json([
                    'message'   => 'Este Usuário ja tem uma conta'
                ], 400);
            }
        }

        $account->save(); 
        return new AccountResource($account);
         
    }

    public function extrato()
    {
       
            $statements = DB::table('users')
                ->join('accounts', 'accounts.user_id', '=', 'users.id')
                ->leftjoin('credits', 'credits.account_id', '=', 'accounts.id')
                ->leftjoin('debits', 'debits.account_id', '=', 'accounts.id')
                ->leftjoin('reversals', 'reversals.account_id', '=', 'accounts.id')
                ->select('users.*', 'accounts.saldo', 'accounts.id', 'credits.valor_credito', 'credits.id', 'debits.valor_debito', 'debits.id','reversals.valor_estorno','reversals.id',)
                ->get();

                return response()->json($statements);               
    }

    
    public function esportaCsv()
    {
 
        $fileName = 'movimentacoes.csv';
        $tasks = DB::table('users')
                ->join('accounts', 'accounts.user_id', '=', 'users.id')
                ->leftjoin('credits', 'credits.account_id', '=', 'accounts.id')
                ->leftjoin('debits', 'debits.account_id', '=', 'accounts.id')
                ->leftjoin('reversals', 'reversals.account_id', '=', 'accounts.id')
                ->select('users.*', 'accounts.saldo', 'accounts.id', 'credits.valor_credito', 'credits.id', 'debits.valor_debito', 'debits.id','reversals.valor_estorno','reversals.id',)
                ->get();

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Id', 'Nome', 'email', 'Aniversário', 'Data Cadastro usuário', 'saldo', 'valor credito', 'valor debito', 'valor estorno');

        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($tasks as $task) {

                $row['Id']  = $task->id;
                $row['Nome']    = $task->name;
                $row['email']    = $task->email;
                $row['Aniversário']  = $task->birthday;
                $row['Data Cadastro usuário']  = $task->created_at;
                $row['saldo']  = $task->saldo;
                $row['valor credito']  = $task->valor_credito;
                $row['valor debito']  = $task->valor_debito;
                $row['valor estorno']  = $task->valor_estorno;

                fputcsv($file, array($row['Id'], $row['Nome'], $row['email'], $row['Aniversário'], $row['Data Cadastro usuário'], $row['saldo'],$row['valor credito'],$row['valor debito'], $row['valor estorno'] ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    

  
}




