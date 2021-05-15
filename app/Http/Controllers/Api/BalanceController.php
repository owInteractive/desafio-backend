<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\BalanceRequest;

use App\Models\User;

class BalanceController extends Controller
{
    /**
     * Return sum of balance and movements by user_id.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($user_id)
    {
        try {
            $user = User::findorFail($user_id);
            $data = [
                'opening_balance'=>$user->opening_balance,
                'history_movements'=>$user->history_movements(),
                'actual_balance'=>$user->actual_balance($user->opening_balance)
            ];
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BalanceRequest $request)
    {
        try {
            $data = $request->all();
            $user = User::findorFail($data['user_id']); 
            $user->update(['opening_balance'=>$data['value']]);

            $response = [
                'data' => $user,
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
