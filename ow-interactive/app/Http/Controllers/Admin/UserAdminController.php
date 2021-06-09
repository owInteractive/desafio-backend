<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService;
use Facade\FlareClient\Http\Exceptions\BadResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = UserService::index($request);
            return Response::success($data);
        } catch (\Throwable $th) {
            return Response::serverError();
        }
    }

    public function show($id)
    {
        try {
            $user = UserService::find($id);
            return Response::success($user);
        } catch (ModelNotFoundException $th) {
            return Response::notFound(['message' => "Usuário $id não encontrado."]);
        } catch (\Throwable $th) {
            return Response::serverError();
        }
    }

    public function destroy($id)
    {
        try {
            if (UserService::destroy($id)) {
                return Response::success(['message' => "Usuário excluído com suceso."]);
            }
            return Response::badRequest(['message' => "Erro ao excluir usuário."]);
        } catch (ModelNotFoundException $th) {
            return Response::notFound(['message' => "Usuário $id não encontrado."]);
        } catch (BadResponse $th) {
            return Response::badRequest(['message' => $th->getMessage()]);
        } catch (\Throwable $th) {
            return Response::serverError();
        }
    }

    public function store(RegisterRequest $request)
    {
        try {
            UserService::store($request);
            return Response::created(["message" => "Usuário criado com sucesso"]);
        } catch (\Throwable $th) {
            return Response::badRequest(["message" => "Erro ao criar usuário"]);
        }
    }
}
