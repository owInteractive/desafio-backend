<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\Movimentacao;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Traits\ResponseTrait;
use Exception;

class UserController extends Controller
{
    public function __construct(
        protected User $repository
    )
    {
        
    }
    use ResponseTrait;
    /**
     * Display a listing of the resource.
     */
    
    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"users"},
     *     summary="Get Users",
     *     description="Lista todos os usuarios.",
     *     operationId="index",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     * )
     */
    public function index()
    {
        return UserResource::collection($this->repository->paginate(50));
    }
    
    /**
     * @OA\Get(
     *     path="/api/users_desc",
     *     tags={"users"},
     *     summary="Lista usuarios em ordem decrescente",
     *     description="Lista todos os usuarios em ordem decrescente.",
     *     operationId="desc",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     * )
     */
    public function desc()
    {
        return UserResource::collection($this->repository->paginate(50)->sortBy([['created_at', 'desc']]));
    }

    /**
     * @OA\Post(
     *      path="/api/users",
     *      operationId="store",
     *      tags={"users"},
     *      summary="Cadastrar Usuario",
     *      description="Retorna dados salvos",
     * @OA\RequestBody(
     *    required=true,
     *    description="Cadastre os dados do usuario",
     *    @OA\JsonContent(
     *       required={"name","email","birthday"},
     *       @OA\Property(property="name", type="string", format="text", example="Fulano"),
     *       @OA\Property(property="email", type="email", format="num", example="fulano@gmail.com"),
     *       @OA\Property(property="birthday", type="string", format="text", example="1999-08-13")
     *    ),
     * ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation", @OA\JsonContent()
     *     ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation", @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request", 
     *          @OA\JsonContent()
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden", @OA\JsonContent()
     *      ),
     *   @OA\Response(response=422, description="Error: Unprocessable Entity")
     * )
     */
    public function store(StoreUserRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $this->repository->create($data);
            return $this->responseSuccess(new UserResource($user),'Usuario criado com sucesso');
        } catch (\Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }

    
    /**
     * @OA\Get(
     *     path="/api/user/{id}",
     *     tags={"users"},
     *     summary="Find user by ID",
     *     description="Returns a single user",
     *     operationId="show",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of user to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplier",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param int $id
     */
    public function show(string $id)
    {
        $user = $this->repository->findOrFail($id);
        return new UserResource($user);
    }

    
    /**
     * @OA\Put(
     *     path="/api/users/{id}",
     *     tags={"users"},
     *     summary="Aualiza saldo inicial de usuario.",
     *     operationId="update",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do usuario",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplier",
     *          @OA\JsonContent()
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="saldo_inicial",
     *                     description="Atualizar saldo inicial",
     *                     type="float"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try {
            $data = $request->validated();
            $user = $this->repository->findOrFail($id);
            $user->update($data);
            return $this->responseSuccess(new UserResource($user),'Registro atualizado com sucesso');
        } catch (\Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }

    
    /**
     * @OA\Delete(
     *     path="/api/users/{id}",
     *     tags={"users"},
     *     summary="Deletes a User",
     *     operationId="deleteUser",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="User id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *     ),
     * )
     */
    public function destroy(string $id)
    {
        try {
            $user = $this->repository->findOrFail($id);
            if(!$user->movimentacoes->isEmpty()||$user->saldo_inicial) throw new Exception('Não é possível excluir usuário que tenha qualquer tipo de movimentação ou saldo');
            $user->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }

    
    /**
     * @OA\Get(
     *     path="/api/somamovimentacao/{id}",
     *     tags={"users"},
     *     summary="Movimentações do usuario",
     *     description="Retorna soma de todas as movimentações (débito, crédito e estorno) mais o saldo inicial do usuário",
     *     operationId="somamovimentacao",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID of user to return",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplier",
     *          @OA\JsonContent()
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *          @OA\JsonContent()
     *     )
     * )
     *
     * @param int $id
     */
    public function somamovimentacao(string $id){
        try {
            $user = $this->repository->findOrFail($id);
            $array = [];
            $array[$user->name]=[
                'soma_movimentacoes'=>$user->soma_movimentacoes(),
                'saldo_inicial'=>$user->saldo_inicial,
            ];
            return response()->json($array);
        } catch (\Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }
}
