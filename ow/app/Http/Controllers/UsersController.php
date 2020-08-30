<?php

namespace App\Http\Controllers;

use App\User;
use App\Operation;
use Illuminate\Http\Request;
use Exception;
use Carbon\Carbon;

class UsersController extends Controller
{
	/*
        Busca todos os usuarios
        @param
    */
    public function index()
    {   
        try
        { 
            return User::all()->sortBy('created_at');
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /*
        Busca um usuario especifico
        @param $user (id)
    */
    public function show(User $user)
    {   
        try
        { 
            return $user;
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /*
        Deleta um usuario especifico
        @param $user (id)
    */
    public function eliminate(User $user)
    {   
        try
        { 
            $returnMoves = $this->showBalance($user);
            $moves       = trim($returnMoves->pluck('moves'), '[]');
            $balance     = $user->opening_balance;

            if($balance > 0){
                return response()->json(['message' => 'Nāo foi possivel exclusāo. Existe saldo na conta deste usuário!'], 400);
            }else if($moves > 0){
                return response()->json(['message' => 'Nāo foi possivel exclusāo. Existem movientações para este usuário!'], 400);
            }else{

                $user->delete();
                return response()->json(['success'=>true], 201);        
            }
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /*
        Atualiza saldo inicial do usuario
        @param $user (id)
    */
    public function updateBalance(User $user, Request $request)
    {   
        try
        { 
            $user->opening_balance = $request->input('opening_balance');
            $user->save();

            return response()->json(['success'=>true], 201);
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    /*
        Consulta a quantidade de movimentacoes do usuario
        @param $user (id)
    */
    public function showBalance(User $user)
    {   
        try
        {   
            $return = Operation::selectRaw('COUNT(id) as moves')
                                ->where('id_user', $user->id)
                                ->get();
            return $return;
        }
        catch (Exception $e)
        {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
