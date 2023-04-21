<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovimentacaoRequest;
use App\Http\Resources\MovimentacaoResource;
use App\Models\Movimentacao;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MovimentacaoController extends Controller
{
    public function __construct(
        protected Movimentacao $repository
    )
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entitys = $this->repository->paginate();
        return MovimentacaoResource::collection($entitys);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovimentacaoRequest $request)
    {
        $data = $request->validated();
        $entity = $this->repository->create($data);
        return new MovimentacaoResource($entity);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $entity = $this->repository->findOrFail($id);
        return new MovimentacaoResource($entity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreMovimentacaoRequest $request, string $id)
    {
        $data = $request->validated();
        $entity = $this->repository->findOrFail($id);
        $entity->update($data);
        return new MovimentacaoResource($entity);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->repository->findOrFail($id)->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }
}
