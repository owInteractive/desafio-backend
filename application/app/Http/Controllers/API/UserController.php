<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AmountInitialUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Throwable;

class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="users.index",
     *      tags={"Users"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Função responsável buscar todos os usuários com ordernação por criação",
     *      description="Retorna uma coleção de usuários",
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
     *     )
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $users = $this->userService->all();
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json(['users' => $users]);
    }

    /**
     * @OA\Post(
     *      path="/users",
     *      operationId="users.store",
     *      tags={"Users"},
     *      summary="Função responsável por enviar os dados para validação e retornar mensagem ao usuário",
     *      description="Retorna mensagem sucesso ao cadastrar e o usuário cadastrado",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")
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
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->store($request->validated());
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json(
            [
                'message' => 'Usuário criado com sucesso.',
                'user'    => $user
            ]
        );
    }

    /**
     * @OA\Get(
     *      path="/users/{id}",
     *      operationId="users.show",
     *      tags={"Users"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Função responsável por buscar um determinado usuário",
     *      description="Retorna os dados do determinado usuário",
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
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
     *          description="User not found",
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
    public function show(int $id): JsonResponse
    {
        try {
            $user = $this->userService->find($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json(['user' => $user]);
    }

    /**
     * @OA\Patch(
     *      path="/users/{id}/amount_initial",
     *      operationId="users.amount_initial",
     *      tags={"Users"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Função responsável atualizar o valor inicial de um determinado usuário",
     *      description="Retorna os dados atualizados do usuário",
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/AmountInitialUserRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found",
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
     * @param AmountInitialUserRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function amountInitial(AmountInitialUserRequest $request, int $id): JsonResponse
    {
        try {
            $user = $this->userService->update($request->validated(), $id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json(['user' => $user]);
    }

    /**
     * @OA\Delete(
     *      path="/users/{id}",
     *      operationId="users.destroy",
     *      tags={"Users"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Função responsável por deletar um determinado usuário",
     *      description="Retorna uma mensagem informando que o usuário foi deletado",
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
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
     *          description="User not found",
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
            $this->userService->destroy($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json(['message' => 'Usuário deletado com sucesso.']);
    }


    /**
     * @OA\Post(
     *      path="/users/{id}/balance",
     *      operationId="users.balance",
     *      tags={"Users"},
     *      security={
     *         {"passport": {}},
     *      },
     *      summary="Função responsável fazer o balanço de todas as transações do usuário.",
     *      description="Retorna as operações, agrupado por seu tipo e seus valores somados com colletion de usuário",
     *      @OA\Parameter(
     *          name="id",
     *          description="User ID",
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
     *          description="User not found",
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
    public function balance(int $id): JsonResponse
    {
        try {
            $user = $this->userService->balance($id);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        } catch (Throwable $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }

        return response()->json(['user' => $user]);
    }
}
