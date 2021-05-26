<?php

namespace App\Services;

use App\Helpers\CSVHelper;
use App\Models\Financial;
use App\Models\Moviment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use UnexpectedValueException;

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

            FinancialService::recalcBalance($financial);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    public static function destroy($id, $userId)
    {

        DB::beginTransaction();
        try {
            $financial = Financial::where('user_id', $userId)->first();
            $financial->moviments()->where('id', $id)->delete();
            FinancialService::recalcBalance($financial);

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public static function report($request, $userId)
    {
        $type = $request->get('type') ?? 'last-month';
        $period = $request->get('period');

        $moviments = Moviment::select(
            'moviments.created_at',
            'moviments.value',
            'moviment_types.name as type'
        )
            ->join('financials', 'financials.id', 'moviments.financial_id')
            ->join('moviment_types', 'moviment_types.id', 'moviments.moviment_type_id')
            ->where('financials.user_id', $userId)
            ->orderByDesc('moviments.id');

        if ($type === 'last-month') {
            $afterDate = date('Y-m-d', strtotime('-30 days'));
            $moviments = $moviments->whereDate('moviments.created_at', '>=', $afterDate);
        } else if ($type === 'period') {
            if (!$period || strlen($period) !== 7 || strpos($period, '-') !== 4)
                throw new UnexpectedValueException("Para usar o filtro de período informa a data no formato YYYY-MM.");

            list($year, $month) = explode('-', $period);
            $moviments = $moviments->whereYear('moviments.created_at', $year)
                ->whereMonth('moviments.created_at', $month);
        }

        $moviments = $moviments->get()->toArray();
        $user = User::with('financial')->find($userId);
        $columns = ['Data', 'Valor', 'Operação'];


        $csvHeader = [
            ['Nome', 'Data de nascimento', 'Saldo inicial', 'Saldo atual'],
            [$user->name, $user->birthday, $user->financial->opening_balance, $user->financial->current_balance]
        ];

        $file = CSVHelper::generateStreamFile($moviments, $columns, $csvHeader);
        return $file;
    }
}
