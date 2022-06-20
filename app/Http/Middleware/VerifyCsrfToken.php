<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/',
        'register',

        'adduser',
        'listusers/*',
        'listuser/*',
        'removeuser/*',
        'edituser/*',
        'userseeder/*',

        'addcharge/*',
        'listinformation/*',
        'removecharge/*',
        'chargesreport/*',
        'editbalance/*',
        'sumtransactions/*',
        'transactionseeder/*',
    ];
}
