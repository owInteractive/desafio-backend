<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
use App\Http\Requests\OpeningBalanceRequest;

class UserController extends Controller
{
    //todas as funções chamam a classe UserRepository

    
    
    /**
     *Mosta a listagem de usuario ordenado por data de criação
     *
     * @return \Illuminate\Http\Response
     */
    public function listUsers()
    {
        return UserRepository::listar();
    }

    /**
     * Salva um novo usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUser(UserRequest $request)
    {
        return UserRepository::store($request);
    }

    /**
     * Mostra um usuario especifico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showUser($id)
    {
        return UserRepository::show($id);
    }

    /**
     * Atualiza um usuario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateOpeningBalance(OpeningBalanceRequest $request, $id)
    {
        return UserRepository::updateOpeningBalance($request,$id);
    }

    /**
     * Remove o usuario.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyUser($id)
    {
        return UserRepository::destroy($id);
    }
}
