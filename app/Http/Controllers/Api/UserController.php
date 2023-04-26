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
     *     path="/users",
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
     *     @OA\Parameter(
     *         name="perPage",
     *         in="query",
     *         description="Contagem por pagina",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             default="1",
     *             type="integer",
     *         )
     *     ),
     * )
     */
    public function index($id=null)
    {
        return UserResource::collection($this->repository->paginate(50));
    }
    
    public function desc()
    {
        return UserResource::collection($this->repository->paginate(50)->sortBy([['created_at', 'desc']]));
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = $this->repository->findOrFail($id);
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = $this->repository->findOrFail($id);
            if(!$user->movimentacoes->isEmpty()||$user->saldo_inicial) return response()->json([],500);
            $user->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
    }

    
    public function usermovimentacao(string $id){
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
