<?php

namespace App\Http\Controllers\Client;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Moviment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MovimentController extends Controller
{
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
