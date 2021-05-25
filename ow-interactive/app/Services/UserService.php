<?php

namespace App\Services;

use App\Models\User;
use Facade\FlareClient\Http\Exceptions\BadResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{

    static function index($request)
    {
        $limit = $request->get('limit') ?? 20;
        $data = User::orderByDesc('id')->paginate($limit);
        return $data;
    }

    static function find($id)
    {
        return User::findOrFail($id);
    }

    static function store($request)
    {
        DB::beginTransaction();
        try {
            $user = new User();
            $user->fill($request->all());
            $user->password = Hash::make($user->password);
            $user->save();
            $user->financial()->create();

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public static function destroy($id)
    {
        $user = User::with(['financial' => function ($builder) {
            $builder->withCount('moviments');
        }])
            ->findOrFail($id);

        if ($user->financial->current_balance > 0 || $user->financial->moviments_count)
            throw new BadResponse("Impossível excluir um usuário com movimentações ou saldo.");

        return $user->delete();
    }
}
