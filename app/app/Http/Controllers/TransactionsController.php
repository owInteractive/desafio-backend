<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExportTransactionRequest;
use App\Http\Requests\TransacionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\Transactions\TransactionServiceContract;
use App\Services\Users\UserServiceContract;
use Exception;
use Illuminate\Http\Response;

class TransactionsController extends Controller
{
    public function __construct(
        protected TransactionServiceContract $transactionService,
        protected UserServiceContract $userService,
    ) {  
    }

    public function store(TransacionRequest $request)
    {
        try {
            $transaction = $this->transactionService->store($request->all());
            if ($transaction) {
                return response()->json('Transação gravado com sucesso', Response::HTTP_OK);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } 
    }

    public function getTransactionsByUser($userId, $paginate)
    {
        try {
            $user = $this->userService->getUser($userId);
            $transactions =$this->transactionService->get($userId, $paginate);

            $response = [
                'user' => $user,
                'transactions' => $transactions,
            ];
            
            return response(new TransactionResource($response), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } 
    }

    public function destroy($id)
    {
        try {
            $this->transactionService->destroy($id);
            
            return response()->json('Transação Excluída', Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function export($userId, ExportTransactionRequest $request)
    {
        try {
            $this->transactionService->export($userId, $request->all());
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
