<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MovementRequest;

use App\Models\User;
use App\Models\Movement;

class MovementController extends Controller
{
    /**
     * Display a listing of the resource bt user_id
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index(Request $request, $user_id)
    { 
        try {
            $user = User::findorFail($user_id);
            $data = $user->movements()->paginate(10);            

            $response = [
                'data' => $data,
                'info_user'=> $user,
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

    /**
     * Display a listing of all resources.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index_all(Request $request)
    {
        try {
            $data = Movement::paginate(10);

            $response = [
                'data' => $data, 
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovementRequest $request)
    {
        try {
            $data = $request->all();
            $movement = Movement::create($data);

            $response = [
                'data' => $movement,
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
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try { 
            $movement = Movement::findorFail($id);            
            $movement->delete();

            $response = [
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
