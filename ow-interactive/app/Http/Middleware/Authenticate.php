<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    /**
     * User not authenticate.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    protected function redirectTo($request)
    {
        return response()->json(['error' => 'Usuário não autenticado.'], 401);
    }
}
