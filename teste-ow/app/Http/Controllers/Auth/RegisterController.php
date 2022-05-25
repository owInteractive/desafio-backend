<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\API\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends BaseController
{
    public function register (Request $request , User $user) 
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name'     => 'required',
            'password' => 'required',
            'email'    => 'required|unique:users',
            'birthday' => 'required|date_format:Y-m-d|only_adults',
        ]);

        if($validator->fails()){
            return $this->sendError('fail request', $validator->errors(), 400);
        }

        if (!$user = $user->create($input)) {
            return $this->sendError('fail create user', $validator->errors(), 500);
        }

        return $this->sendResponse($user, 'user created'); 
    }
}
