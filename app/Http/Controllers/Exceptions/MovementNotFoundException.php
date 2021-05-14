<?php

namespace App\Http\Controllers\Exceptions;

class MovementNotFoundException extends HttpException
{
    protected $statusCode = 404;

    public function __construct()
    {
        parent::__construct('Movimentação não encontrado.');
    }
}
