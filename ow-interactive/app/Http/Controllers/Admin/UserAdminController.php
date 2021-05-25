<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserAdminController extends Controller
{
    public function index(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? 20;
            $data = User::orderByDesc('id')->paginate($limit);
            return Response::success($data);
        } catch (\Throwable $th) {
            return Response::serverError();
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
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
            $user = User::with(['financial' => function ($builder) {
                $builder->withCount('moviments');
            }])
                ->findOrFail($id);

            if ($user->financial->current_balance || $user->financial->moviments_count)
                return  Response::badRequest(['message' => "Impossível excluir um usuário com movimentações ou saldo."]);


            if ($user->delete()) {
                return Response::success(['message' => "Usuário excluído com suceso."]);
            }
            return Response::badRequest(['message' => "Erro ao excluir usuário."]);
        } catch (ModelNotFoundException $th) {
            return Response::notFound(['message' => "Usuário $id não encontrado."]);
        } catch (\Throwable $th) {
            return Response::serverError();
        }
    }
}
