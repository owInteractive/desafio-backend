<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MovementsExport;

class FiltersController extends Controller
{
    /*Método para exportar usuários*/
    public function export(Request $request, $perPage = 10, $page = 1)
    {  
        try {
            $file_name = 'movements.xlsx';
            Excel::store(new MovementsExport($perPage,$page),$file_name,'movements_uploads'); 

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
