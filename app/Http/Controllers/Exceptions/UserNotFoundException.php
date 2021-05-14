<?php

namespace App\Http\Controllers\Exceptions;

class UserNotFoundException extends HttpException
{
    protected $statusCode = 404;

    public function __construct()
    {
        parent::__construct('Usuário não encontrado.');
    }
}
