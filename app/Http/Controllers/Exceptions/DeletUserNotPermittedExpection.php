<?php

namespace App\Http\Controllers\Exceptions;

class DeletUserNotPermittedExpection extends HttpException
{
    protected $statusCode = 422;

    public function __construct()
    {
        parent::__construct('Não é possível deletar o usuário, pois ele tem movientações ou saldo.');
    }
}
