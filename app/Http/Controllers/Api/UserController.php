<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(
        protected User $repository
    )
    {
        
    }
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
     * )
     */
    public function index($id=null)
    {
        $users = ($id) ? User::findOrFail($id)->paginate() : $this->repository->paginate();
        return UserResource::collection($users);
    }
    
    public function desc()
    {
        $users = $this->repository->paginate()->sortBy([['created_at', 'desc']]);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $user = $this->repository->create($data);
        return new UserResource($user);
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
        $data = $request->validated();
        $user = $this->repository->findOrFail($id);
        $user->update($data);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = $this->repository->findOrFail($id);
        if(!$user->movimentacoes->isEmpty()||$user->saldo_inicial) return response()->json([],500);
        $user->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }

    
    public function usermovimentacao(string $id){
        $user = $this->repository->findOrFail($id);
        $array = [];
        $array[$user->name]=[
            'soma_movimentacoes'=>$user->soma_movimentacoes(),
            'saldo_inicial'=>$user->saldo_inicial,
        ];
        return response()->json($array);
    }
}
