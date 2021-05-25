<?php

namespace App\Services;

use App\Models\Financial;
use App\Models\Moviment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MovimentService
{
    public static function index($request, $userId)
    {
        $userId = Auth::user()->id;
        $limit = $request->get('limit') ?? 20;

        $user = User::with('financial:id,user_id,current_balance')
            ->findOrFail($userId);

        $moviments = Moviment::select(
            'moviments.id',
            'moviments.value',
            'moviments.created_at',
            'moviment_types.name as type'
        )
            ->join('moviment_types', 'moviment_types.id', 'moviments.moviment_type_id')
            ->where('moviments.financial_id', $user->financial->id)
            ->orderByDesc('moviments.id')
            ->paginate($limit);

        $user->financial->moviments = $moviments;

        return $user;
    }

    public static function store($request, $userId)
    {
        DB::beginTransaction();

        try {
            $financial = Financial::where('user_id', $userId)->first();
            $financial->moviments()->create($request->all());

            $financial->current_balance = $request->get('moviment_type_id') === 1 ?
                $financial->current_balance - $request->get('value') :
                $financial->current_balance + $request->get('value');

            $financial->save();

            DB::commit();

            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public static function destroy($id, $userId)
    {

        try {
            $moviment = Moviment::join('financials', 'financials.id', 'moviment.financial_id')
                ->where('financials.user_id', $userId)
                ->findOrFail($id);

            return $moviment->delete();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
