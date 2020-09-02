<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\JsonResponse;

class Authenticate extends Middleware
{
    /**
     * Informa ao usuário quando não está autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse
     */
    protected function redirectTo($request): JsonResponse
    {
        return response()->json(['error' => 'Usuário não autenticado.'], 401);
    }
}
