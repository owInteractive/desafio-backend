<?php

namespace App\Http\Controllers\Client;


use App\Helpers\CSVHelper;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Services\FinancialService;
use App\Services\MovimentService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use UnexpectedValueException;

class MovimentController extends Controller
{

    public function index(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $user = MovimentService::index($request, $userId);
            return Response::success($user);
        } catch (\Throwable $th) {
            return Response::serverError();
        }
    }

    public function store(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            MovimentService::store($request, $userId);
            return Response::success(["message" => "Movimento registrado com sucesso."]);
        } catch (\Throwable $th) {
            return Response::badRequest(["message" => "Erro ao registrar movimento."]);
        }
    }

    public function destroy($id)
    {
        try {
            $userId = Auth::user()->id;

            if (MovimentService::destroy($id, $userId))
                return Response::success(['message' => "Movimentação excluída com suceso."]);

            return Response::badRequest(['message' => "Erro ao excluir movimentação."]);
        } catch (ModelNotFoundException $th) {
            return Response::notFound(['message' => "Movimentação $id não encontrada."]);
        } catch (\Throwable $th) {
            return Response::serverError();
        }
    }

    public function report(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $makeFile = MovimentService::report($request, $userId);
            $fileName = "movimentações-$userId";
            $headers = CSVHelper::getResponseHeader($fileName);
            return Response::stream($makeFile, $headers);
        } catch (UnexpectedValueException $th) {
            return Response::badRequest(['message' => $th->getMessage()]);
        } catch (\Throwable $th) {
            return Response::serverError();
        }
    }

    public function changeOpeningBalance(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            FinancialService::changeOpeningBalance($request, $userId);
            return Response::success(['Saldo inicial alterado com sucesso.']);
        } catch (ModelNotFoundException $th) {
            return Response::notFound(['message' => "Usuário não encontado."]);
        } catch (\Throwable $th) {
            return Response::serverError();
        }
    }

    public function balance()
    {
        try {
            $userId = Auth::user()->id;
            $financial = FinancialService::balance($userId);
            return Response::success($financial);
        } catch (ModelNotFoundException $th) {
            return Response::notFound(['message' => "Usuário $userId não encontrado."]);
        } catch (\Throwable $th) {
            return Response::serverError();
        }
    }
}
