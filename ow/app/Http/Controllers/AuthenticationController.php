<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthenticationController extends Controller
{
	/*
		Inserir usuario
		$param request
	*/
    public function register(Request $request)
    {
    	try
        {
            $date   = new Carbon();
            $ages   = $date->subYears(18)->format("Y-m-d");

            $request->validate([
        		'name' 		=> 'required|string|max:255|min:1',
        		'email' 	=> 'required|string|email',
        		'birthday'	=> 'required|date|before:'.$ages,
                'password'  => 'required|string',
        	]);

            $user = User::create([
        		'name' 		=> $request->input('name'),
        		'email' 	=> $request->input('email'),
        		'birthday'	=> $request->input('birthday'),
                'password'  => Hash::make($request->input('password'))
        	]);

        	return response()->json(['success'=>true], 201);
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /*
		Login com token
		$param request
	*/
    public function login(Request $request)
    {
    	try
        {
            $request->validate([
	        	'email' 	=> 'required|string|email',
	        	'password'  => 'required|string',
        	]);

			$credentials = [
				'email' 	=> $request->input('email'),
	        	'password'  => $request->input('password'),
			];

			if(!Auth::attempt($credentials)){
				return response()->json(['message' => 'Erro na autenticaçāo'], 401);
			}

			$user 	= $request->user();
			$token 	= $user->createToken('AccessToken')->accessToken;

			return response()->json(['message' => 'Logado com sucesso', 'token' => $token], 200);

	    }
        catch (Exception $e)
        {
        	return response()->json(['message' => $e->getMessage()], 400);
        }
          	
    }

    /*
		Logout
		$param request
	*/
    public function logout(Request $request)
    {
    	try
    	{
    		$request->user()->token()->revoke();
	    	return response()->json(['message' => 'Deslogado com sucesso'], 200);
    	}
        catch (Exception $e)
        {
        	return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
