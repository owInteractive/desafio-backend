<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\FiltersRequest;

use App\Exports\MovementsExport;

class FiltersController extends Controller
{
    /**
     * Store file xlsx containing a filtered collection
     * @return \Illuminate\Support\Collection
     */ 
    public function export(FiltersRequest $request)
    {  
        try {
            $file_name = time().'movements.csv';
            Excel::store(new MovementsExport($request),$file_name,'movements_uploads'); 

            $response = [
                'file_url' => url('/')."/uploads/".$file_name, 
                'success' => true
            ];
            $status = 200;

        } catch (\Throwable $th) {

            $response = [
                'error'=>$th->getMessage(),
                'success' => false
            ];
            $status = 500;
        }
        
        return response($response,$status); 
    }
}
