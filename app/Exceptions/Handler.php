<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Exception;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'api_token',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Exception $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if (null !== $e->getStatusCode()) {
            return response()->json([
                'error_' . $e->getStatusCode() => 'An error was found on your request. Please use one of the following routes to continue:',
                '.---------' => '----------',
                'USERS' => '-',
                '/register (POST)' => 'Registers a new user. Returns the new user\'s API key,',
                '/adduser (POST)' => 'Adds a new user. Returns the new user\'s API key,',
                '/listusers/{page_number}/{quantity_by_page} (POST)' => 'Lists information of all users,',
                '/listuser/{id} (POST)' => 'Lists information of only one user,',
                '/edituser/{id} (PUT)' => 'Edits the information of a user,',
                '/removeuser/{id} (DELETE)' => 'Deletes a user,',
                '/userseeder/{quantity} (POST)' => 'Seeds new users.',
                '..--------' => '----------',
                'TRANSACTIONS' => '-',
                '/addcharge/{id} (POST)' => 'Adds charges to the user\'s balance,',
                '/listinformation/{id}/{page_number}/{quantity_by_page} (POST)' => 'Lists information of a user\'s balance,',
                '/chargesreport/{id}/{filter} (POST)' => 'Lists information of a user\'s balance in a period of time,',
                '/sumtransactions/{id} (POST)' => 'Lists user\'s transactions, and initial and current balance,',
                '/editbalance/{id} (PUT)' => 'Edits user\'s initial balance,',
                '/removecharge/{id} (DELETE)' => 'Deletes a charge from a user\'s balance,',
                '/transactionseeder/{id}/{quantity} (POST)' => 'Seeds charges to a user\'s balance.',
            ]);
        } else {
            return response()->json([
                'error' => 'The server found and error and could not recover. Please use one of the following routes to continue:',
                '.---------' => '----------',
                'USERS' => '-',
                '/register (POST)' => 'Registers a new user. Returns the new user\'s API key,',
                '/adduser (POST)' => 'Adds a new user. Returns the new user\'s API key,',
                '/listusers/{page_number}/{quantity_by_page} (POST)' => 'Lists information of all users,',
                '/listuser/{id} (POST)' => 'Lists information of only one user,',
                '/edituser/{id} (PUT)' => 'Edits the information of a user,',
                '/removeuser/{id} (DELETE)' => 'Deletes a user,',
                '/userseeder/{quantity} (POST)' => 'Seeds new users.',
                '..--------' => '----------',
                'TRANSACTIONS' => '-',
                '/addcharge/{id} (POST)' => 'Adds charges to the user\'s balance,',
                '/listinformation/{id}/{page_number}/{quantity_by_page} (POST)' => 'Lists information of a user\'s balance,',
                '/chargesreport/{id}/{filter} (POST)' => 'Lists information of a user\'s balance in a period of time,',
                '/sumtransactions/{id} (POST)' => 'Lists user\'s transactions, and initial and current balance,',
                '/editbalance/{id} (PUT)' => 'Edits user\'s initial balance,',
                '/removecharge/{id} (DELETE)' => 'Deletes a charge from a user\'s balance,',
                '/transactionseeder/{id}/{quantity} (POST)' => 'Seeds charges to a user\'s balance.',
            ]);
        }

        return parent::render($request, $e);
    }
}
