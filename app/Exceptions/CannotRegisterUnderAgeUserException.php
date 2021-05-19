<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class CannotRegisterUnderAgeUserException extends HttpException
{
    public function __construct(int $statusCode = 406, ?string $message = 'The user have to be of age to register'){
        parent::__construct($statusCode, $message);
    }
}
