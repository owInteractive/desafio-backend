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
     * @OA\Get(
     *     path="/api/movimentacoes",
     *     tags={"Movimentações"},
     *     summary="Listar movimentações",
     *     description="Lista todos as movimentações.",
     *     operationId="listMovimentacao",
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
        $entitys = $this->repository->paginate();
        return MovimentacaoResource::collection($entitys);
    }

    
    /**
     * @OA\Post(
     *      path="/api/movimentacoes",
     *      operationId="storeMovimentacao",
     *      tags={"Movimentações"},
     *      summary="Cadastrar Movimentação",
     *      description="Retorna dados salvos",
     * @OA\RequestBody(
     *    required=true,
     *    description="Cadastre a movimentação do usuario",
     *    @OA\JsonContent(
     *       required={"operacao","valor","user_id"},
     *       @OA\Property(property="operacao", type="string", format="text", example="DEBITO"),
     *       @OA\Property(property="valor", type="int", format="num", example="200"),
     *       @OA\Property(property="user_id", type="int", format="num", example="1")
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
     *       @OA\Response(response=422, description="Error: Unprocessable Entity")
     * )
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
     * @OA\Delete(
     *     path="/api/movimentacoes/{id}",
     *     tags={"Movimentações"},
     *     summary="Deleta uma movimentação",
     *     operationId="deleteMovimentacao",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="Id do registro para deletar",
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
     *         description="Movimentacao not found",
     *     ),
     * )
     */
    public function destroy(string $id)
    {
        $this->repository->findOrFail($id)->delete();
        return response()->json([],Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Post(
     *     path="/api/movimentacoes_export",
     *     tags={"Movimentações"},
     *     summary="Exporta CSV com lista de movimentações.",
     *     description="Lista todos as movimentações em CSV.",
     *     operationId="exportMovimentacao",
     * @OA\RequestBody(
     *    required=true,
     *    description="Listar as movimentações a partir do filtros. Os filtros que podem ser utilizados são: ultimos_30dias, passando mês/ano, ex: 04/2023 ",
     *    @OA\JsonContent(
     *       @OA\Property(property="filtro", type="string", format="text", example="ultimos_30dias"),
     *    ),
     * ),
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
    public function export() 
    {   
        return Excel::download(new MovimentacoesExport, 'movimentacoes.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
