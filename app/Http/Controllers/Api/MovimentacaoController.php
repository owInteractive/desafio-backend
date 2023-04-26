<?php

namespace App\Http\Controllers\Api;

use App\Exports\MovimentacoesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMovimentacaoRequest;
use App\Http\Resources\MovimentacaoResource;
use App\Models\Movimentacao;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Traits\ResponseTrait;

class MovimentacaoController extends Controller
{
    public function __construct(
        protected Movimentacao $repository
    )
    {}
    use ResponseTrait;
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
        try {
            $data = $request->validated();
            $entity = $this->repository->create($data);
            $entity = new MovimentacaoResource($entity);
            return $this->responseSuccess($entity,'Movimentação criada com sucesso');
        } catch (\Exception $e) {
            return $this->responseError([],$e->getMessage());
        }
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

    public function export() 
    {   
        return Excel::download(new MovimentacoesExport, 'movimentacoes.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
