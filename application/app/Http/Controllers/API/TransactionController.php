<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExportTransactionRequest;
use App\Http\Requests\IndexTransactionRequest;
use App\Http\Requests\StoreTransactionRequest;
use App\Services\TransactionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class TransactionController extends Controller
{
    private TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * @OA\Get(
     *      path="/transactions",
     *      operationId="transactions.index",
     *      tags={"Transactions"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Função responsável buscar informações todas as transações dos usuários",
     *      description="Retorna transações do usuário com paginação",
     *      @OA\Parameter(
     *          name="page",
     *          description="Page this pagination",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="per_page",
     *          description="Amount of data per page",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      )
     * )
     *
     * @param IndexTransactionRequest $request
     * @return JsonResponse
     */
    public function index(IndexTransactionRequest $request)
    {
        try {
            $transaction = $this->transactionService->paginate($request->validated());
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json($transaction);
    }

    /**
     * @OA\Post(
     *      path="/transactions",
     *      operationId="transactions.store",
     *      tags={"Transactions"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Função responsável por criar uma nova transação e retornar ao usuário",
     *      description="Retorna mensagem sucesso ao cadastrar e a transação cadastrada",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreTransactionRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      )
     * )
     *
     * @param StoreTransactionRequest $request
     * @return JsonResponse
     */
    public function store(StoreTransactionRequest $request): JsonResponse
    {
        try {
            $transaction = $this->transactionService->store($request->validated());
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json(
            [
                'message'     => 'Transação criada com sucesso.',
                'transaction' => $transaction
            ]
        );
    }

    /**
     * @OA\Delete(
     *      path="/transactions/{id}",
     *      operationId="transactions.destroy",
     *      tags={"Transactions"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Função responsável por deletar uma determinada transação",
     *      description="Retorna uma mensagem informando que a transação foi deletada",
     *      @OA\Parameter(
     *          name="id",
     *          description="Transaction ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Transaction not found",
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      )
     * )
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->transactionService->destroy($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Transação não encontrada'], 404);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json(['message' => 'Transação deletada com sucesso.']);
    }

    /**
     * @OA\Post(
     *      path="/transactions/export",
     *      operationId="transactions.export",
     *      tags={"Transactions"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Função responsável por criar um excel de exportação",
     *      description="Retorna uma mensagem informando o link de download",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ExportTransactionRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Internal Server Error"
     *      )
     * )
     *
     * @param ExportTransactionRequest $request
     * @return JsonResponse
     */
    public function export(ExportTransactionRequest $request): JsonResponse
    {
        try {
            $url = $this->transactionService->export($request->validated());
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json(['message' => $url]);
    }
}
