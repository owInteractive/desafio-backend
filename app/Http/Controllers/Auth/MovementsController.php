<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MovementRequest;

use App\Models\Movement;

class MovementsController extends Controller
{
    /**
     * Display a listing of the resource bt user_id
     *
     * @return \Illuminate\Http\Response
     */ 
    public function index(Request $request)
    { 
        try {
            $user = $request->user();
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MovementRequest $request)
    {
        try {
            $data = $request->all();
            $user = $request->user();
            $movement = $user->movements()->create($data); 

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
    public function destroy(Request $request, $id)
    {
        try { 
            $movement = Movement::findorFail($id);    
             
            /**
             * Check if movement belongs to auth user
             */
            if($movement->user_id != $request->user()->id){
                throw new \Exception("Essa movimentação não pertence ao usuário logado"); 
            }

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
