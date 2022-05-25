<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\API\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * @group Authentication
 *
 * API endpoints for managing authentication
 */
class LoginController extends BaseController
{   
    /**
     *  make login in api
     * 
     *  @param $request
     */
    public function login(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'password' => 'required',
            'email'    => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('fail request', $validator->errors(), 400);       
        }

        if (!Auth::attempt($input)) {
            abort(401, 'Invalid Credentials');
        }

        $token = auth()->user()->createToken('auth_token')->plainTextToken;

        return $this->sendResponse(['token' => $token , 'user' => auth()->user()->id], 'logon');
    }

    /**
     *  do logout in api
     */    
    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->sendResponse([],'logout');
    }

}
