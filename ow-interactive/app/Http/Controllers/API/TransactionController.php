<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateTransactionRequest;
use App\Http\Requests\ExportTransactionRequest;
use App\Models\Transaction;
use App\Repositories\TransactionRepository;
use Response;


class TransactionController extends AppBaseController
{
    /** @var  TransactionRepository */
    private $transactionRepository;

    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @OA\Get(
     *      path="/transactions",
     *      operationId="transactions.index",
     *      tags={"Transactions"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Get a listing of the Transactions.",
     *      description="Get all Transactions",
     *      @OA\Parameter(
     *          name="page",
     *          description="Page this pagination",
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
     */
    public function index()
    {
        try {
            $transactions = Transaction::with('user')
                ->with('transactionType')
                ->paginate(10);

            return $this->sendResponse($transactions, 'Transactions retrieved successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/transactions/store",
     *      operationId="transactions.store",
     *      tags={"Transactions"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Create a newly created Transaction in storage",
     *      description="Create Transaction",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateTransactionRequest")
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
     */
    public function store(CreateTransactionRequest $request)
    {
        try {
            $input = $request->all();
            $transaction = $this->transactionRepository->create($input);
            return $this->sendResponse($transaction->toArray(), 'Transaction saved successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Delete(
     *      path="/transactions/destroy/{id}",
     *      operationId="transactions.destroy",
     *      tags={"Transactions"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Remove the specified Transaction from storage",
     *      description="Delete Transaction",
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
     *      )
     * )
     */
    public function destroy($id)
    {
        try {
            $transaction = $this->transactionRepository->find($id);
            if (empty($transaction)) {
                return $this->sendError('Transaction not found');
            }
            $transaction->delete();
            return $this->sendSuccess('Transaction deleted successfully');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }

    /**
     * @OA\Post(
     *      path="/transactions/export",
     *      operationId="transactions.export",
     *      tags={"Transactions"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Creating excel to export transactions",
     *      description="Returns the download link",
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
     */
    public function export(ExportTransactionRequest $request)
    {
        try {
            $spreadsheet = $this->transactionRepository->export($request->all());
            return $this->sendResponse($spreadsheet, 'Successfully exported transactions');
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 500);
        }
    }
}
