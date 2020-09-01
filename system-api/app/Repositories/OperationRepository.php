<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use App\Models\Operation;

class OperationRepository{

   public static function create($request){

      try 
      {
         $operation = Operation::create($request->all());
         if($operation){
            return response()->json(['message' => 'Operação Cadastrada com Sucesso'], 200);
         }
      } 
      catch (Exception $e) 
      {
         return response()->json(['message' => $e->getMessage()], 400);
      }
   }

   public static function show($id){

      try 
      {
         $user = User::find($id);
         if($user){
            $movi = Operation::where('user_id',$id)->paginate(10);
            if($movi){
               return response()->json([
                  'usuario' => $user,
                  'movimentacao' => $movi
               ], 200);
            }
            else {
               return response()->json(['message' => 'Usuário não tem movimentação'], 404);
            }
         } else {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
         }
      } 
      catch (Exception $e) 
      {
         return response()->json(['message' => $e->getMessage()], 400);
      }
   }

   public static function delete($user_id, $operation_id)
   {
      try 
      {
         $user = User::find($user_id);
         if($user){
            $movi = Operation::find($operation_id);
            if($movi){
               $movi->delete();
               return response()->json(['message' => 'Movimentação deletada com sucesso'], 200);
            }
            else {
               return response()->json(['message' => 'Usuário não tem movimentação'], 404);
            }
         } else {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
         }
      } 
      catch (Exception $e) 
      {
         return response()->json(['message' => $e->getMessage()], 400);
      }
   }

   public static function totalOperations($id){

      try 
      {
         $user = User::find($id);
         if($user){
            $movi = Operation::where('user_id',$id)->get();
            if($movi){
               $total = $user->opening_balance;
               foreach($movi as $i => $m){
                  if($m->operation_type_id == 1){
                     $total = $total + $m->amount;
                  }
                  if($m->operation_type_id == 2){
                     $total = $total - $m->amount;
                  }
                  if($m->operation_type_id == 3){
                     $id_anterior = $i - 1;
                     if($m[$id_anterior]->operation_type_id == 1){
                        $total = $total - $m->amount;
                     } else {
                        $total = $total + $m->amount;
                     }
                  }
                  echo $total.'<br>';
               }
               return $total;
            }
            else {
               return response()->json(['message' => 'Usuário não tem movimentação'], 404);
            }
         } else {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
         }
      } 
      catch (Exception $e) 
      {
         return response()->json(['message' => $e->getMessage()], 400);
      }
   }

}