<?php

namespace App\Http\Controllers;

use AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        if (strtolower(request()->method()) != 'post') {
            return response()->json([
                'request_method_error' => 'Not allowed. This endpoint should be accessed through POST method.'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'birthday' => 'required|date',
            'password' => 'required|min:8',
            'initial_balance' => 'required|numeric|between:0,9999999999.99'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 401);
        } else {
            $post_data = [
                'name' => $request->name,
                'email' => $request->email,
                'birthday' => $request->birthday,
                'password' => $request->password,
                'initial_balance' => $request->initial_balance
            ]; 
        }

        $user = User::create([
            'name' => $post_data['name'],
            'email' => $post_data['email'],
            'birthday' => $post_data['birthday'],
            'password' => Hash::make($post_data['password']),
            'initial_balance' => $post_data['initial_balance'],
            'current_balance' => $post_data['initial_balance']
        ]);

        $token = $user->createToken('authToken')->plainTextToken;

        User::where('email', $post_data['email'])
            ->update(['api_token' => $token]);

        return response()->json([
            'api_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
