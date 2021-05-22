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
            $data = User::paginate($limit);
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
}
