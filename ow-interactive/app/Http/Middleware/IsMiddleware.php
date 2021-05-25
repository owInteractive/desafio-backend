<?php

namespace App\Http\Middleware;

use App\Helpers\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles)
    {
        $roles = explode('|', $roles);
        $user = Auth::user();
        if (!in_array($user->role, $roles)) return Response::forbidden();
        return $next($request);
    }
}
