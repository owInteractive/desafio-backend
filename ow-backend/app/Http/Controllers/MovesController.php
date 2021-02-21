<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Movement;
use App\Exports\MovesExport;
use App\Exports\Moves30DayExport;
use Maatwebsite\Excel\Facades\Excel;

class MovesController extends Controller
{
    public function movement( Request $request) {
        $array = ['error' => ''];

        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'value' => 'required'
        ]);

        if($validator->fails()) {
            $array['error'] = $validator->errors()->first();
            return response()->json($array, 406);
        }

        //RECEBENDO TYPO DE MOVIMENTAÇÃO E O SEU VALOR
        $type = $request->input('type');
        $value = $request->input('value');

        $user = Auth()->user();
        if(!$user) {
            $array['error'] = 'Este usuário não existe';
            return response()->json($array, 406);
        }

        //SWITCH PARA IDENTIFICAR O TIPO DE MOVIMENTAÇÃO E REALIZAR A MESMA

        switch($type) {
            case 'credit':
                $moviment = new Movement();
                $moviment->type  = $type;
                $moviment->value = $value;
                $moviment->id_user = $user['id'];
                $moviment->save();

                $user->credit = $user->credit - $value;
                $user->save();
                $array['message'] = 'Creditado usado sucesso!';
                
                break;

            case 'debit':
                $moviment = new Movement();
                $moviment->type  = $type;
                $moviment->value = $value;
                $moviment->id_user = $user['id'];
                $moviment->save();

                $user->balance = $user->balance - $value;
                $user->save();
                $array['message'] = 'Débito usado com sucesso!';

                break;

            case 'reversal-credit':
                $moviment = new Movement();
                $moviment->type  = $type;
                $moviment->value = $value;
                $moviment->id_user = $user['id'];
                $moviment->save();

                $user->credit = $user->credit + $value;
                $user->save();
                $array['message'] = 'Estorno de crédito recebido com sucesso!';
                break;

            case 'reversal-debit':
                $moviment = new Movement();
                $moviment->type  = $type;
                $moviment->value = $value;
                $moviment->id_user = $user['id'];
                $moviment->save();

                $user->balance = $user->balance + $value;
                $user->save();
                $array['message'] = 'Estorno de débito recebido com sucesso!';
                break;

                default:
                $array['moviment'] = 'opção inválida';
        }

        return $array;
    }

    public function getMovements (Request $request) {
        $array = ['error' => ''];
        
            $user = Auth()->user();
            if($user) {
                $moves = Movement::where('id_user', $user['id'])->paginate(4);
                $array['user'] = $user;
                $array['user']['moves'] = $moves;
            }

        return $array;

    }

    public function delMovement (Request $request) {
        $array = ['error' => ''];

        $user = Auth()->user();
        $idItem = $request->input('id');

        if($idItem) {
            Movement::where('id', $idItem)->where('id_user', $user['id'])->delete();
            $array['message'] = 'Movimentação deletada!';
        } else {
            $array['error'] = 'Informe o id da movimentação que deseja deletar!';
            return response()->json($array, 406);
        }

        return $array;
    }

    public function export () {
        return Excel::download(new MovesExport, 'moves.csv');
    }

    public function export30days () {
        return Excel::download(new Moves30DayExport, 'moves30.csv');
    }
    
}
