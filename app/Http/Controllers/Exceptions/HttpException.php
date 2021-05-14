<?php

namespace App\Http\Controllers\Exceptions;

use Exception;

class HttpException extends Exception
{
    protected $statusCode = 500;

    public function __construct(string $message)
    {
        parent::__construct($message);
    }

    public function __get($key)
    {
        return $this->$key;
    }
}
