<?php

namespace App\Exceptions;
use Symfony\Component\HttpKernel\Exception\HttpException;


class CannotDeleteUserWithTransactionsException extends HttpException
{
    public function __construct(int $statusCode = 406, ?string $message = 'You cannot delete this user: has transactions'){
        parent::__construct($statusCode, $message);
    }
}
