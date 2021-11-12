<?php

namespace App\Http\Controllers;

use App\Jobs\TransactionFactory;
use App\Jobs\TransactionFactory as TransactionFactoryAlias;
use App\Method;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;

class TransactionsController
{

    /**
     * @OA\Get(
     *      path="/transaction/show/{id}",
     *      tags={"/transaction"},
     *      summary="Listar usuário",
     *      description="Listar usuário",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não encontrado!"
     *      )
     * )
     */
    public function index($id)
    {
        $user = User::where('id', $id)->first();

        $transactionFactory = new TransactionFactory();

        if(!$user){
            return response()->json(["msg" => "Usuário não encontrado!"], 404);
        }

        $data = [
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email,
            "birthday" => $user->birthday,
            "balance" => $user->balance,
            "transactions" => [
                $transactionFactory->createTransacation($user->transactions)
            ]
        ];

        return response()->json($data);
    }

    /**
     * @OA\GET(
     *      path="/transaction/debit/{id}/{value}",
     *      tags={"/transaction"},
     *      summary="Debitar saldo ao usuário",
     *      description="Debitar saldo ao usuário",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *     @OA\Parameter(
     *          name="value",
     *          description="value",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não encontrado!"
     *      )
     * )
     */
    public function debit(Request $request, $id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json(["msg" => "Usuário não encontrado!"], 404);
        }

        if($user->balance < $request->value){
            return response()->json(["msg" => "Impossivel realizar a operação!"], 404);
        }

        $balance = $user->balance - $request->value;

        $user->balance = $balance;
        $user->save();

        return Transaction::create([
            "user_id" => $id,
            "methods_id" => 2,
            "value" => $balance
        ]);
    }

    /**
     * @OA\GET(
     *      path="/transaction/credit/{id}/{value}",
     *      tags={"/transaction"},
     *      summary="Creditar saldo ao usuário",
     *      description="Creditar saldo ao usuário",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *     @OA\Parameter(
     *          name="value",
     *          description="value",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não encontrado!"
     *      )
     * )
     */
    public function credit(Request $request, $id)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json(["msg" => "Usuário não encontrado!"], 404);
        }

        if($user->balance > $request->value){
            return response()->json(["msg" => "Impossivel realizar a operação!"], 404);
        }

        $balance = $user->balance + $request->value;

        $user->balance = $balance;
        $user->save();

        return Transaction::create([
            "user_id" => $id,
            "methods_id" => 1,
            "value" => $request->value
        ]);
    }

    public function chargeback()
    {

    }

    /**
     * @OA\Delete(
     *      path="/transaction/delete-transaction/{id}/{transaction}",
     *      tags={"/transaction"},
     *      summary="Deletar Usuário",
     *      description="Deletar Usuário",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="transaction",
     *          description="transaction",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Usuário deletado com sucesso!",
     *          @OA\JsonContent()
     *       ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não existe"
     *      )
     * )
     */
    public function destroyTransaction(Request $request, $id, $transaction)
    {
        $user = User::where('id', $id)->first();

        if(!$user){
            return response()->json(["msg" => "Transação não encontrada!"], 404);
        }

        Transaction::destroy($transaction);


        return response()->json(["msg" => "Transação excluida com sucesso!"], 404);
    }
}
