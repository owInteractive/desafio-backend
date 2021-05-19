<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class GenericModelNotFoundException extends HttpException{

    public function __construct($id,$className,$statusCode = 406){

        parent::__construct($statusCode, $message = "{$className} id: `{$id}` not found");

    }
}
