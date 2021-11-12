<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;


class UsersController
{
    /**
     * @OA\Get(
     *     tags={"/users"},
     *     summary="Listar todos os usuários",
     *     description="Listar todos os usuários",
     *     path="/users",
     *
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *      ),
     *     @OA\Response(
     *         response="400",
     *         description="Invalid tag value",
     *     ),
     *
     *
     * )
     */
    public function index()
    {
        return User::latest('created_at')->get();
    }


    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      tags={"/users"},
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
     *
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não encontrado!"
     *      )
     * )
     */
    public function show($id)
    {
        $user = User::find($id);
        return (!$user)
            ? response()->json(['data' => ['message' => 'Usuário não encontrado!']], 404)
            : response()->json($user);

    }

    /**
     * @OA\Post(
     *      path="/users",
     *      tags={"/users"},
     *      summary="Criar Usuário",
     *      description="Criar Usuário",
     *      @OA\RequestBody(
     *          required=true,
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="birthday", type="string"),
     *              @OA\Property(property="balance", type="string"),
     *
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Usuário criado com sucesso",
     *
     *       ),
     *
     *      @OA\Response(
     *          response=404,
     *          description="Menor de idade"
     *      )
     * )
     */
    public function store(Request $request)
    {
        $birthday = $request->birthday;
        $year = explode('-', $birthday);
        $date = date('Y');

        $verify = $date - $year[0];

        if($verify < 18){
            return response()->json(['data' => ['message' => 'Cadastro permitido somente para maiores de idade!']], 404);
        }

        User::create($request->all());

        return response()
            ->json([
                'data' => [
                    'message' => 'Usuário criado com sucesso!'
                ],
            ], 201);
    }

    /**
     * @OA\Delete(
     *      path="/users/{id}",
     *      tags={"/users"},
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
    public function destroy($id)
    {
        $user = User::find($id);

        if($user->balance > 0){
            throw new \Exception('Usuário não pode ser excluido por ter movimentação na conta!') ;
        }


        if (!$user) {
            return response()
                ->json([
                    'data' => [
                        'message' => 'Usuário não existe!'
                    ]
                ], 404);
        }

        User::destroy($user->id);

        return response()
            ->json([
                'data' => [
                    'message' => 'Usuário deletado com sucesso!'
                ]
            ], 204);
    }

    /**
     * @OA\GET(
     *      path="/users/{id}/{value}",
     *      tags={"/users"},
     *      summary="Adicionar saldo ao usuário",
     *      description="Adicionar saldo ao usuário",
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
    public function add($id, $value = null)
    {
        $user = User::find($id);

        if(!$user){
            return response()->json(['data' => ['message' => 'Usuário não encontrado!']], 404);
        }

        $user->balance = $value;
        return response()->json(['data' => ['message' => 'Valor alterado com sucesso!']]);
    }

}
