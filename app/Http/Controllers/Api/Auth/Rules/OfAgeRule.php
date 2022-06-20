<?php
namespace App\Http\Controllers\Api\Auth\Rules;

use Closure;
use DateTime;
use Exception;

class OfAgeRule
{
    public function handle($payload, Closure $next)
    {
        $birthday = new DateTime($payload['birthday']);
        $age = $birthday->diff( new DateTime( date('Y-m-d')))->format( '%Y');
        if ($age<=17) {
            throw new Exception('User don`t of age!');
        }
        return $next($payload);
    }
}
