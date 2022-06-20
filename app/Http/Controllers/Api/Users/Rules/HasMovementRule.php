<?php
namespace App\Http\Controllers\Api\Users\Rules;

use Closure;
use Exception;

class HasMovementRule
{
    /**
     * @throws Exception
     */
    public function handle($user, Closure $next)
    {
        if ($user->movements->count()) {
            throw new Exception('User has movements!');
        }
        return $next($user);
    }
}
