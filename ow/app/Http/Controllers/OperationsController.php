<?php

namespace App\Http\Controllers;

use App\Operation;
use App\User;
use App\StatusType;
use App\TransactionType;
use Illuminate\Http\Request;
use Exception;
use Response;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class OperationsController extends Controller
{
    
    /*
        Busca todas operações com paginaçāo (10 operações por pagina)
        @param $operation (id)
    */
    public function index()
    {   
        try
        { 
            return Operation::paginate(10);
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /*
        Busca uma operaçāo especifica pelo seu id
        @param $operation (id)
    */
    public function show(Operation $operation)
    {   
        try
        { 
            return $operation;
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /*
        Busca operações pelo id usuario e seus dados pessoais com paginaçāo (10 operações por pagina)
        @param $user (id)
    */
    public function showUser(User $user)
    {   
        try
        {
        	return Operation::join('users','users.id','operations.id_user')
        						->where('id_user', $user->id)
        						->paginate(10);
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /*
        Busca operações pelo seu tipo de status
        @param $status (id)
    */
    public function showStatus(StatusType $status)
    {   
        try
        {
        	return Operation::all()->where('id_status_type', $status->id);
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /*
        Busca operações pelo seu tipo de transaçāo
        @param $transaction (id)
    */
    public function showTransaction(TransactionType $transaction)
    {   
        try
        {
        	return Operation::all()->where('id_transaction_type', $transaction->id);
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /*
        Deleta uma operaçāo relacionado a um usuario especifico
        @param $operation
        @param $user
    */
    public function eliminate(Operation $operation, User $user)
    {   
        try
        { 
        	Operation::where([
        		['id','=',$operation->id], 
        		['id_user','=',$user->id]
        	])->delete();

            return response()->json(['success'=>true], 201);
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /*
        Relatorio CSV via GET
        @param $request (value)
    */
    public function reportGet($param, User $user=null)
    {
        
        $month = '';
        $year  = '';

        if(strlen($param)>2)
        {
            $month      = substr($param, 0,2);
            $year       = substr($param, 2,2);
            $value      = 2;
        }

        switch($param){
            case '30': // Filtro = Operações dos ultimos 30 dias
                $condition  = 'operations.created_at >= "'.Carbon::today()->subDays(30).'"';
                break;
            case '2': // Filtro = Operações do mês e ano especifico
                $condition  = 'MONTH(operations.created_at) = '.$month.' AND SUBSTRING(year(operations.created_at),1,2) = '.$year;
                break;
            case '0': // Filtro = Todas as operações 
                $condition = '1=1';
                break;
            default: // Filtro = Default todas as operações
                return response()->json(['message' => 'Parâmetro Invalido', 'valid' => array('30 = Ultimos 30 dias','MMAA = Mês e Ano de Referência (Ex.: 0620)','0 = Todos os Registro')], 400);
                break;
        }

        $whereUser = ($user) ? ' AND users.id = '.$user->id.'' : ''; 

        $return = Operation::select('operations.id', 
                                    'operations.value', 
                                    'operations.created_at',
                                    'users.name as userName',
                                    'transaction_types.name as transactionName',
                                    'status_types.name as status')
                            ->join('users','users.id','operations.id_user')
                            ->join('transaction_types','transaction_types.id','operations.id_transaction_type')
                            ->join('status_types','status_types.id','operations.id_status_type')
                            ->whereRaw($condition.$whereUser)
                            ->get();

        // consulta o saldo atual do usuario
        $dataUser = ($user) ? $this->amountUser($user) : '';
    
        $columns = array('Id', 'Usuario', 'Tipo_Transacao', 'Status', 'Valor', 'Data');
        $callback = function() use ($return, $columns, $user, $dataUser)
        {
            
            $file = fopen('php://output', 'w');

            if($user){
                $nome   = trim($dataUser->pluck('name'),'"[""""]"');
                $email  = trim($dataUser->pluck('email'),'"[""""]"');
                $balance = trim($dataUser->pluck('current_balance'),'"[""""]"');

                fputcsv($file, array("Nome", $nome),';');
                fputcsv($file, array("Email", $email),';');
                fputcsv($file, array("Saldo", $balance), ';');
            }

            fputcsv($file, $columns,';');

            foreach($return as $data) {
                $date = date('d/m/Y', strtotime($data->created_at));
                fputcsv($file, array($data->id, $data->userName, $data->transactionName, $data->status, $data->value, $date),';');
            }
            fclose($file);
        };

        $headers = array(
            "Content-type"          => "text/csv",
            "Content-Disposition"   => "attachment; filename=".Carbon::now().".csv",
            "Pragma"                => "no-cache",
            "Cache-Control"         => "must-revalidate, post-check=0, pre-check=0",
            "Expires"               => "0"
        );

        return Response::stream($callback, 200, $headers);
    }

    /*
        Relatorio CSV via POST
        @param $request (value)
    */
    public function reportPost(Request $request)
    {
        $value = $request->input('value');
        $month = '';
        $year  = '';

        if (strpos($value, '/') !== false)
        {
            $period     = explode('/', $value);
            $collection = collect($period);
            $month      = $collection[0];
            $year       = $collection[1];
            $value      = 2;
        }

        switch($value){
            case '30': // Filtro = Operações dos ultimos 30 dias
                $condition  = 'operations.created_at >= "'.Carbon::today()->subDays(30).'"';
                break;
            case '2': // Filtro = Operações do mês e ano especifico
                $condition  = 'MONTH(operations.created_at) = '.$month.' AND SUBSTRING(year(operations.created_at),1,2) = '.$year;
                break;
            case '0': // Filtro = Default todas as operações 
                $condition = '1=1';
                break;
            default: 
                return response()->json(['message' => 'Parâmetro value Invalido', 'valid' => array('30 = Ultimos 30 dias','08/20 = Mês e Anos de Referência (Fomato: MM/AA)','0 = Todos os Registros')], 400);
                break;
        }

        $return = Operation::select('operations.id', 
                                    'operations.value', 
                                    'operations.created_at',
                                    'users.name as userName',
                                    'transaction_types.name as transactionName',
                                    'status_types.name as status')
                            ->join('users','users.id','operations.id_user')
                            ->join('transaction_types','transaction_types.id','operations.id_transaction_type')
                            ->join('status_types','status_types.id','operations.id_status_type')
                            ->whereRaw($condition)
                            ->get();

        $columns = array('Id', 'Usuario', 'Tipo_Transacao', 'Status', 'Valor', 'Data');
        $callback = function() use ($return, $columns)
        {
            $file = fopen('php://output', 'w');

            fputcsv($file, $columns, ';');

            foreach($return as $data) {
                $date = date('d/m/Y', strtotime($data->created_at));

                fputcsv($file, array($data->id, $data->userName, $data->transactionName, $data->status, $data->value, $date), ';');
            }
            fclose($file);
        };

        $headers = array(
            "Content-type"          => "text/csv",
            "Content-Disposition"   => "attachment; filename=file.csv",
            "Pragma"                => "no-cache",
            "Cache-Control"         => "must-revalidate, post-check=0, pre-check=0",
            "Expires"               => "0"
        );

        return Response::stream($callback, 200, $headers);
    }

    /*
        Soma de todas as movimentações de um usuario
        @param $user (id)
    */
    public function amountUser(User $user)
    {   
        try
        {   
            $return = Operation::selectRaw('operations.id_user,
                                            users.name,
                                            users.email,
                                            ((users.opening_balance +
                                            (select COALESCE(SUM(value),0) FROM base_ow.operations WHERE id_transaction_type IN (2,3) and id_user = '.$user->id.')) -
                                            (select COALESCE(SUM(value),0) FROM base_ow.operations WHERE id_transaction_type = 1 and id_user = '.$user->id.')
                                            ) as current_balance')
                                ->join('users','users.id','operations.id_user')
                                ->where('operations.id_user', $user->id)
                                ->groupBy('operations.id_user','users.email') 
                                ->get();

            return $return;
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

}
