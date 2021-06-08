<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\User as UserResource;
use App\Models\Account;
use App\Models\Movimentacao;
use DateTime;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        //ordena os usuários pela data de cadastro
        return User::orderBy('created_at')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = New User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->birthday = $request->input('birthday');
        //altera formatação de data para brasileiro
        date('d-m-Y', strtotime($user->birthday));
        $user->saldo_inicial = $request->input('saldo_inicial');
        
        //incluindo condição maior que 18 para cadastro
        $nascimento = $user->birthday;
        $dados = new DateTime($nascimento);
        $intervalo = $dados->diff(new DateTime( date('d-m-Y')));
        $idade = $intervalo->format('%Y');
  
        if (intval($idade) > 18) {
            
            $user->save();
            return new UserResource( $user );
             
        } else {

            return response()->json([
                'message'   => 'Erro, Usuário menor de 18 anos',
            ], 400);
        }
 
    }

    public function alteraSaldoInicial(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);
        // valida se existe o usuário pelo id informado
        if (!is_null($user)) {
            //se existir usuário, valida se o valor é maior que 0
            $user->saldo_inicial = $request->input('valor');
            if($user->saldo_inicial <= 0.00) {
                return response()->json([
                    'message'   => 'Valor não pode ser menor ou igual a 0.00',
                ], 400);
            }


        } else {
            return response()->json([
                'message'   => 'Usuário não econtrado',
            ], 400);
        }

  
        if( $user->save() ){
            return new UserResource( $user );
          }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Int $id)
    {   
        // mostra usuario pelo id informado
        $userId = User::find($id);
        if(is_null($userId)) {
            return response()->json([
                'message'   => 'Usuário não econtrado',
            ], 400);
        } else {
            return $userId;
        }
                
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {

        try {

            //valida se não existe alguma movimentação para o usuário informado pelo id
            $userId = User::find($id);
            if(is_null($userId)) {

                return response()->json([
                    'message'   => 'Usuário não econtrado',
                ], 400);

            } else {
                // se existir, faz a exclusão
                $userId->delete();
                return response()->json([
                    'message'   => 'Usuário deletado com sucesso',
                ], 200);
            }
         
        } catch (\PDOException $e) {
           // se existir alguma movimentação, informa mensagem de erro.
           return response()->json([
                'message'   => 'Usuário não pode ser excluido, existem movimentações para este ID',
            ], 200); 
        }
    }
}
