<?php

namespace App\Http\Controllers;

 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Account as AccountResource;
use App\Models\Account;
use App\Models\User;
 
class AccountController extends Controller
{
    public function criarConta(Request $request)
    {
        $account = New Account();
        $account->user_id = $request->input('user_id');        
      

        //procura dentro da tabela usuarios, algum que exista com o numero de id recebido
        $user = User::find($account->user_id);
              
        //se não econtrar, retorna mesangem
        if (is_null($user)) {
            return response()->json([
                'message'   => 'Usuário não cadastrado para se criar uma conta',
            ], 400);
        }
        
        // compara o id recebi com a tabela Account para ver se este usuario ja possui uma conta aberta
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
            //join entre todas as tabelas
            $statements = DB::table('users')
                ->leftjoin('accounts', 'users.id', '=', 'accounts.user_id')
                ->leftjoin('credits', 'accounts.id', '=', 'credits.account_id')
                ->leftjoin('debits', 'accounts.id', '=', 'debits.account_id')
                ->leftjoin('reversals', 'accounts.id', '=', 'reversals.account_id')
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

        //configurações cabeçario
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        //montando as colunas
        $columns = array('Id', 'Nome', 'email', 'Aniversário', 'Data Cadastro usuário', 'saldo', 'valor credito', 'valor debito', 'valor estorno');

        //incluindo colunas no arquivo csv
        $callback = function() use($tasks, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
        
            //incluindo dados do banco no arquivo csv
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

        return response()->streamDownload($callback, 200, $headers);
    }

    public function esportaCsvUltimos30Dias()
    {
 
        $fileName = 'movimentacoes.csv';
        $tasks = DB::table('users')
                ->leftjoin('accounts', 'accounts.user_id', '=', 'users.id')
                ->leftjoin('credits', 'credits.account_id', '=', 'accounts.id')
                ->leftjoin('debits', 'debits.account_id', '=', 'accounts.id')
                ->leftjoin('reversals', 'reversals.account_id', '=', 'accounts.id')
                ->select('users.*', 'accounts.saldo', 'accounts.id', 'credits.valor_credito', 'credits.id', 'debits.valor_debito', 'debits.id','reversals.valor_estorno','reversals.id',)
                ->where('accounts.updated_at', '>', date('Y-m-d', strtotime('-1 month')))                 
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
    

    public function somaMovimentacoes()
    {
        $values = DB::table('users')
        ->leftjoin('accounts', 'accounts.user_id', '=', 'users.id')
        ->leftjoin('credits', 'credits.account_id', '=', 'accounts.id')
        ->leftjoin('debits', 'debits.account_id', '=', 'accounts.id')
        ->leftjoin('reversals', 'reversals.account_id', '=', 'accounts.id')
        ->get();



        foreach ($values as $key => $number) {

           $credito = isset($number->valor_credito) != null ? intval($number->valor_credito) : 0;
           $saldo =  isset($number->saldo_inicial) != null ? intval($number->saldo_inicial) : 0;
           $debito = isset($number->valor_debito) != null ? intval($number->valor_debito) : 0;
           $estorno = isset($number->valor_estorno) != null ? intval($number->valor_estorno) : 0;
            
            $sum =  $credito + $saldo + $debito + $estorno;

        }

        return response()->json([
            'saldo inicial'   => $saldo,
            'valor credito'   => $credito,
            'valor debito'    => $debito,
            'valor estorno'   => $estorno,
            'total'           => $sum  
        ], 200);

    }
}




