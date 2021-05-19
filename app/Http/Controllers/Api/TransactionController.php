<?php

namespace App\Http\Controllers\Api;

use App\Exports\TransactionsExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Resources\GenericCollection;
use App\Http\Services\TransactionService;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use Carbon\Carbon;
use Facade\Ignition\Support\Packagist\Package;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Maatwebsite\Excel\Excel;

class TransactionController extends Controller
{
    private $transactionService;

    public function __construct(TransactionService $service)
    {
        $this->transactionService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return GenericCollection
     */
    public function index(Request $request)
    {
        $currentPage = $request->get('page') ? $request->get('page') : 0;

        return new GenericCollection($this->transactionService->index()->paginated($request->get('png'), $currentPage));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(TransactionStoreRequest $request)
    {
        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $this->transactionService->create($request->all())
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'status' => 200,
            'success' => true,
            'data' => $this->transactionService->show($id)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return response()->json([
            'status' => 200,
            'success' => $this->transactionService->destroy($id)
        ], 200);
    }

    public function export(Excel $excel, Request $request)
    {

        return $this->transactionService->export($request->all());
    }
}
