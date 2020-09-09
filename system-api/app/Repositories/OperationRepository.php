<?php

namespace App\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Operation;
use Response;

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
            $total = OperationRepository::getTotalAmount($id);
            return $total;
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

   public static function exportCVS($filter, $id)
   {
      try 
      {
         $user = User::find($id);

         if(strlen($filter) > 2){
            if(strpos($filter, '-')){
               list($mes,$ano) = explode('-',$filter);
               $filter = 2;
            } else {
               $mes = substr($filter, 0,2);
               $ano = substr($filter, 2,4);
               $filter = 2;
            }
         }
         //dd($filter,$mes,$ano);

         if(is_null($user)){
            if($filter == 30){
               $trintadias = Carbon::today()->subDays(30);
               $operations = Operation::where('created_at','>=',$trintadias)->get();
            } 
            else if ($filter == 2)
            {
               if(strlen($ano) < 2){
                  if($ano > 50){
                     $ano = '19'.$ano;
                  } else {
                     $ano = '20'.$ano;
                  }
               }
               $operations = Operation::whereMonth('created_at',$mes)->whereYear('created_at',$ano)->get();
            } 
            else if ($filter == 0)
            {
               $operations = Operation::all();
            }
            $totalUser = 0;
         } else {

            $totalUser = OperationRepository::getTotalAmount($user->id);

            if($filter == 30){
               $trintadias = Carbon::today()->subDays(30);
               $operations = Operation::where('user_id',$user->id)->where('created_at','>=',$trintadias)->get();
            } 
            else if ($filter == 2)
            {
               if(strlen($ano) < 2){
                  if($ano > 50){
                     $ano = '19'.$ano;
                  } else {
                     $ano = '20'.$ano;
                  }
               }
               $operations = Operation::where('user_id',$user->id)->whereMonth('created_at',$mes)->whereYear('created_at',$ano)->get();
            } 
            else if ($filter == 0)
            {
               $operations = Operation::where('user_id',$user->id)->get();
            } else {
               return response()->json(['message' => 'Parametro incorreto, Informe "30" para trinta dias, MM/AA para Mes e Ano ou "0" para todos os registros.'], 404);
            }
         }
         $columns = array('Id','Tipo Transação','Valor','Data');
         $fileCsv = function() use ($operations,$user,$totalUser,$columns)
         {
            $file = fopen('php://output', 'w');

            if(!is_null($user)){
               fputcsv($file, array("nome", $user->name),';');
               fputcsv($file, array("email", $user->email),';');
               fputcsv($file, array("Saldo", $totalUser),';');
            }
            fputcsv($file,$columns,';');

            foreach($operations as $o){
               fputcsv($file, array($o->id, $o->operationType->name, $o->amount, $o->created_at),';');
            }

            fclose($file);
         };
         $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=file.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
         ];
         
         return Response::stream($fileCsv, 200, $headers);
      }
      catch (Exception $e) 
      {
         return response()->json(['message' => $e->getMessage()], 400);
      }
   }

   public static function getTotalAmount($id){
      $user = User::find($id);
      $movi = Operation::where('user_id',$id)->get();
      //dd($movi);
      if($movi){
         $total = $user->opening_balance;
         foreach($movi as $i => $m){
            if($m->operation_type_id == 1){
               $total = $total + $m->amount;
            }
            else if($m->operation_type_id == 2){
               $total = $total - $m->amount;
            }
            else if($m->operation_type_id == 3){
               $id_anterior = $i - 1;
               /* if($m[$id_anterior]->operation_type_id == 1){
                  $total = $total - $m->amount;
               } else {
                  $total = $total + $m->amount;
               } */
            }
         }
         return $total;
      }else {
         return response()->json(['message' => 'Usuário não tem movimentação'], 404);
      }
   }

}