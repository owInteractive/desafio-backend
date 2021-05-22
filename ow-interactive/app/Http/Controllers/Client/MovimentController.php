<?php

namespace App\Http\Controllers\Client;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Moviment;
use Illuminate\Http\Request;

class MovimentController extends Controller
{
    public function store(Request $request)
    {
        try {
            $financial = Financial::where('user_id', $request->get('user_id'))->first();
            if (!$financial) {
                $financial = new Financial();
                $financial->user_id = $request->get('user_id');
                $financial->save();
            }
            $financial->moviments()->create($request->all());
            return Response::success(["message" => "Movimento registrado com sucesso."]);
        } catch (\Throwable $th) {
            return Response::badRequest(["message" => "Erro ao registrar movimento."]);
        }
    }
}
