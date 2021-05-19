<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class CannotDeleteUserWithBalanceException extends HttpException
{
    public function __construct(int $statusCode = 406, ?string $message = 'You cannot delete this user: balance bigger than 0'){
        parent::__construct($statusCode, $message);
    }
}
