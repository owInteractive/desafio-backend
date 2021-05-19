<?php


namespace App\Exceptions;
use Symfony\Component\HttpKernel\Exception\HttpException;


class EmailAlreadyRegisteredException extends HttpException
{
    public function __construct(int $statusCode = 406, ?string $message = 'Email already registered')
        {
            parent::__construct($statusCode, $message);
        }
}
