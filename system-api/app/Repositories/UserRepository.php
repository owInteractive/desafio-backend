<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use App\Models\Operation;
use App\Http\Requests\UserRequest;

class UserRepository
{
   public static function listar(){
      try
      { 
         return User::all()->sortBy('created_at');
      }
      catch (Exception $e)
      {
         return response()->json(['message' => $e->getMessage()], 400);
      }
   }

   public static function store($request){
      try 
      {
         $user = User::create($request->all());
         if($user){
            return response()->json(['message' => 'Usuário Cadastrado com Sucesso'], 200);
         }
      } 
      catch (Exception $e) 
      {
         return response()->json(['message' => $e->getMessage()], 400);
      }
   }

   public static function show($id)
   {
      try
      { 
         $user = User::find($id);
         if(!$user){
               return response()->json(['message' => 'Usuário não encontrado.'], 404);
         } else {
               return User::find($id);
         }
      }
      catch (Exception $e)
      {
         return response()->json(['message' => $e->getMessage()], 400);
      }
   }

    public static function updateOpeningBalance($request,$id){
      try 
      {
         $user = User::find($id);
         if($user)
         {
            $user->opening_balance = $request->opening_balance;
            $user->save();

            return response()->json(['message' => 'Saldo Inicial Alterado com Sucesso'], 200);
         } 
         else 
         {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
         }
      } 
      catch (Exception $e) 
      {
         return response()->json(['message' => $e->getMessage()], 400);
      }
    }

    public static function destroy($id)
    {
        try {
            $user = User::find($id);
            $move = Operation::where('user_id',$id)->get();
            if($user->opening_balance > 0){
               return response()->json(['message' => 'Exite saldo para o cliente, impossível excluir'],400);
            } else if($move > 0){
               return response()->json(['message' => 'Exite Movimentação para o cliente, impossível excluir'],400);
            } else {
               $user->delete();
               return response()->json(['success'=>true],201);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()],400);
        }
    }
}