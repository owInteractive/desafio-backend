<?php

namespace App\Http\Controllers;

use App\Models\Movimentacao;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\Movimentacao as MovimentacaoResource;
use Illuminate\Support\Facades\DB;

class MovimentacoesController extends Controller
{
    public function associaMovimentacao(Request $request ) 
    {   
        //pegas os dados enviados
        $move = New Movimentacao();
        $move->valor = $request->input('valor');
        $move->nome_movimentacao = $request->input('nome da movimentacao');
        $move->user_id = $request->input('id do usuário');

        //valida o nome das movimentações 
        if ($move->nome_movimentacao != "estorno" && $move->nome_movimentacao != "debito" && $move->nome_movimentacao != "credito") {
            return response()->json([
                'message'   => 'Nome da moventação inexistente',
            ], 400);

        }

        //valida se o valor da movimentação é maior que zero
        if($move->valor <= 0.00) {
            return response()->json([
                'message'   => 'Valor não pode ser menor ou igual a 0.00',
            ], 400);
        }

        //valida se existe usuario com o id informado
        $user = User::find($move->user_id);
        if (is_null($user)) {
     
            return response()->json([
                'message'   => 'Não existe conta cadastrado com este user_id',
            ], 400); 
            
        }else {
            if($move->save()) return new MovimentacaoResource($move);
      
        }

 

    }

    public function extrato()
    {
           //pega os dados da tabela users junto com a tabela movimentações
            $statements = DB::table('users')
            ->join('movimentacoes', 'movimentacoes.user_id', '=', 'users.id')
            ->get();

            return response()->json($statements);               
    }


    public function excluirMovimentacao(Int $id)
    {
           //valida se não existe alguma movimentação informado pelo id
            $move = Movimentacao::find($id);
            if(is_null($move)) {

                return response()->json([
                    'message'   => 'Movimentação não econtrada por esse id',
                ], 400);

            } else {

                
                // se existir, faz a exclusão
                $move->delete();
                return response()->json([
                    'message'   => "Movimentação id $id deletada com sucesso",
                ], 200);
            }
       
    }



    public function esportaCsv($filtro)
    {
        //nome do arquivo csv
        $fileName = 'movimentacoes.csv';

        //se o parametro passado na url for 30, responde com as informações de movimentação dos ultimos 30 dias
        if ($filtro == 30) {

            $tasks = DB::table('users')
            ->join('movimentacoes', 'users.id', '=', 'movimentacoes.user_id')
            ->select('users.*', 'movimentacoes.nome_movimentacao', 'movimentacoes.user_id', 'movimentacoes.valor', 'movimentacoes.updated_at')
            ->where('movimentacoes.updated_at', '>', date('Y-m-d', strtotime('-1 month')))
            ->get();

        //se o parametro passado na url for tudo, responde com todas as movimentações
        } elseif ($filtro == 'tudo') {

            $tasks = DB::table('users')
            ->join('movimentacoes', 'users.id', '=', 'movimentacoes.user_id')
            ->select('users.*', 'movimentacoes.nome_movimentacao', 'movimentacoes.user_id', 'movimentacoes.valor', 'movimentacoes.updated_at')
            ->get();
        }



        //configurações cabeçario
        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        //montando as colunas
        $columns = array('Id', 'Nome', 'email', 'Aniversário', 'Data Cadastro usuário', 'saldo inicial', 'nome da movimentacao', 'valor', 'data da movimentação');

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
                $row['saldo inicial']  = $task->saldo_inicial;
                $row['Nome da movimetação']  = $task->nome_movimentacao;
                $row['valor']  = $task->valor;
                $row['data da movimentação']  = $task->updated_at;
            

                fputcsv($file, array($row['Id'], $row['Nome'], $row['email'], $row['Aniversário'], $row['Data Cadastro usuário'], $row['saldo inicial'],$row['Nome da movimetação'],$row['valor'], $row['data da movimentação'] ));
            }

            fclose($file);
        };

        return response()->streamDownload($callback, 200, $headers);
    }

    public function somaMovimentacoes()
    {
        $values = User::join('movimentacoes', 'users.id', '=', 'movimentacoes.user_id')
        ->select('users.id','users.saldo_inicial', 'movimentacoes.nome_movimentacao',  'movimentacoes.valor',)
        ->get();

     
        foreach ($values as $value) {

           $saldo = isset($value->saldo_inicial) != null ? intval($value->saldo_inicial) : 0;
           $valor =  isset($value->valor) != null ? intval($value->valor) : 0;
 
            
            $sum =  $valor + $saldo;

        }

        return response()->json([
            'id do usuário'          => $value->id,
            'saldo inicial'          => $saldo,
            'nome da movimentacao'   => $value->nome_movimentacao,
            'valor'                  => $valor,
            'total'                  => $sum  
        ], 200);

    }
}


