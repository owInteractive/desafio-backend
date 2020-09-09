<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\OperationRequest;
use App\Repositories\OperationRepository;

class OperationController extends Controller
{
    //todas as funções chamam a classe OperationsRepository


    /**
     * Salva uma nova operação.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOperation(OperationRequest $request)
    {
        return OperationRepository::create($request);
    }

    /**
     * Mostra as operações de um usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOperation($id)
    {
        return OperationRepository::show($id);
    }

    /**
     * Remove uma operação especifica.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyOperation($user_id, $operation_id)
    {
        return OperationRepository::delete($user_id,$operation_id);
    }

    //Retorna o Saldo total do Usuario
    public function totalOperations($id)
    {
        return OperationRepository::totalOperations($id);
    }

    //Exporta arquivo CSV
    public function exportCSV($filter,$id=null)
    {
        return OperationRepository::exportCVS($filter,$id);
    }
}
