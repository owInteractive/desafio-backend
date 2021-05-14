<?php

namespace App\Http\Controllers\Exceptions;

class InvalidDataException extends HttpException
{
    protected $statusCode = 422;
    protected $errors = [];

    public function __construct(array $errors = [])
    {
        parent::__construct('Os dados fornecidos são inválidos.');
        $this->errors = $errors;
    }
}
