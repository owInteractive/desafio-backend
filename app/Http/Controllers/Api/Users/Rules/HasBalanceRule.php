<?php
namespace App\Http\Controllers\Api\Users\Rules;

use Closure;
use Exception;

class HasBalanceRule
{
    /**
     * @throws Exception
     */
    public function handle($user, Closure $next)
    {
        if ($user->opening_balance>0) {
            throw new Exception('User has balance!');
        }
        return $next($user);
    }
}
