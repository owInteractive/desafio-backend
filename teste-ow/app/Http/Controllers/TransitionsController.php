<?php

namespace App\Http\Controllers;

use App\helpers\TransitionsHelpers;
use App\Http\Controllers\API\BaseController;
use App\Http\Requests\StoreTransitionsRequest;
use App\Models\Transitions;
use App\Models\User;
use App\Services\FileServices;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransitionsController extends BaseController
{
    protected $transitions;
    protected $createFIle;
    protected $helpers;

    const HEADERS = ['id', 'data', 'tipo', 'valor', 'user_id', 'email'];

    public function __construct()
    {
        $this->transitions = new Transitions;
        $this->fileService = new FileServices;
        $this->helpers     = new TransitionsHelpers;
    }

    /**
     * Display a listing of the resource.
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transitions = $this->transitions->select('*')->paginate();

        return $this->sendResponse($transitions, 'transitions found');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTransitionsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransitionsRequest $request)
    {
        $transition = $this->transitions->create($request->all());

        return $this->sendResponse($transition, 'transition created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transitions  $transitions
     * @return \Illuminate\Http\Response
     */
    public function show(Transitions $transition)
    {
        return $this->sendResponse($transition, 'transitions found');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transitions  $transitions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transitions $transition)
    {
        $transition->deleteOrFail();

        return $this->sendResponse($transition, 'transitions');
    }

    public function download(Request $request)
    {
        $dateNow = Carbon::now()->format('Y-m-d');
        $nameFile = "transitions {$dateNow}.csv";

        if ($request->filled('days')) {
            $data = $this->transitions->getFromDays($request->days);
        }

        if ($request->filled('month_year')) {
            $data = $this->transitions->getFromMouthYear($request->month_year);
        }

        if (!$request->filled('month_year') && !$request->filled('mouthYear')){
            $data = $this->transitions->all();
        }

        $dataCsv = $this->helpers->transformDataToCSV($data);
        $this->fileService->createCSVFile($dataCsv, self::HEADERS, $nameFile);
        $filePath = storage_path('app/public/tmp') . '/' . $nameFile;

        return response()->download($filePath);
    }
}
