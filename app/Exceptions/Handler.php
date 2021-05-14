<?php

namespace App\Exceptions;

use App\Http\Controllers\Exceptions\HttpException;
use App\Http\Controllers\Exceptions\InvalidDataException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Throwable;

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
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->wantsJson()) {
            $response['message'] = $e->getMessage();
            $status = 500;

            if ($e instanceof HttpException) {
                $status = $e->statusCode;
                if ($e instanceof InvalidDataException) {
                    $response['errors'] = $e->errors;
                }
            }

            return response()->json($response, $status);
        }

        return parent::render($request, $e);
    }
}
