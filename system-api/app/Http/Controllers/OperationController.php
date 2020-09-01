<?php

namespace App\Http\Controllers;

use App\Http\Requests\OperationRequest;
use App\Repositories\OperationRepository;
use Illuminate\Http\Request;

class OperationController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeOperation(OperationRequest $request)
    {
        return OperationRepository::create($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOperation($id)
    {
        return OperationRepository::show($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyOperation($user_id, $operation_id)
    {
        return OperationRepository::delete($user_id,$operation_id);
    }

    public function totalOperations($id)
    {
        return OperationRepository::totalOperations($id);
    }
}
