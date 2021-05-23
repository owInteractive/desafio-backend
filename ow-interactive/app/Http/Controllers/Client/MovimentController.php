<?php

namespace App\Http\Controllers\Client;

use App\Helpers\CSVHelper;
use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Financial;
use App\Models\Moviment;
use App\Models\User;
use App\Services\FinancialService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

    public function destroy($id)
    {
        try {
            $moviment = Moviment::findOrFail($id);

            if ($moviment->delete()) {
                return Response::success(['message' => "Movimentação excluída com suceso."]);
            }

            return Response::badRequest(['message' => "Erro ao excluir movimentação."]);
        } catch (ModelNotFoundException $th) {
            return Response::notFound(['message' => "Movimentação $id não encontrada."]);
        } catch (\Throwable $th) {
            return Response::serverError();
        }
    }

    public function report(Request $request)
    {

        $type = $request->get('type') ?? 'last-month';
        $period = $request->get('period');
        $userId = $request->get('userId');

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
                return Response::badRequest(["message" => "Para usar o filtro de período informa a data no formato YYYY-MM."]);

            list($year, $month) = explode('-', $period);
            $moviments = $moviments->whereYear('moviments.created_at', $year)
                ->whereMonth('moviments.created_at', $month);
        }

        $moviments = $moviments->get()->toArray();
        $columns = ['Data', 'Valor', 'Operação'];
        $fileName = "movimentações-$userId";

        $file = CSVHelper::generateStreamFile($moviments, $columns);
        $headers = CSVHelper::getResponseHeader($fileName);

        return response()->stream($file, 200, $headers);
    }

    public function changeOpeningBalance(Request $request)
    {
        DB::beginTransaction();
        try {
            $userId = $request->get('user_id');
            $financial = Financial::where('user_id', $userId)->first();
            $financial->opening_balance = $request->opening_balance;
            FinancialService::recalcBalance($financial);
            DB::commit();
            return Response::success(['Saldo inicial alterado com sucesso.']);
        } catch (ModelNotFoundException $th) {
            DB::rollback();
            return Response::notFound(['message' => "Usuário não encontado."]);
        } catch (\Throwable $th) {
            DB::rollback();
            return Response::serverError();
        }
    }
}
