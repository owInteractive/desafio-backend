<?php

namespace App\Http\Controllers\Client;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Moviment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimentController extends Controller
{

    public function index(Request $request)
    {
        try {
            $userId = $request->get('userId');
            $limit = $request->get('limit') ?? 20;


            $user = User::with('financial:id,user_id,current_balance')
                ->findOrFail($userId);

            $moviments = Moviment::select(
                'moviments.value',
                'moviments.created_at',
                'moviment_types.name as type'
            )
                ->join('moviment_types', 'moviment_types.id', 'moviments.moviment_type_id')
                ->where('moviments.financial_id', $user->financial->id)
                ->orderByDesc('moviments.id')
                ->paginate($limit);

            $user->financial->moviments = $moviments;

            return Response::success($user);
        } catch (\Throwable $th) {
            throw $th;
            return Response::serverError();
        }
    }

    public function store(Request $request)
    {

        DB::beginTransaction();

        try {
            $financial = Financial::where('user_id', $request->get('user_id'))->first();

            if (!$financial) {
                $financial = new Financial();
                $financial->user_id = $request->get('user_id');
                $financial->save();
            }

            $financial->moviments()->create($request->all());

            $financial->current_balance = $request->get('moviment_type_id') === 1 ?
                $financial->current_balance - $request->get('value') :
                $financial->current_balance + $request->get('value');

            $financial->save();

            DB::commit();

            return Response::success(["message" => "Movimento registrado com sucesso."]);
        } catch (\Throwable $th) {
            DB::rollback();
            return Response::badRequest(["message" => "Erro ao registrar movimento."]);
        }
    }
}
