<?php
namespace App\Repositories\Movement\Filters;

use Carbon\Carbon;
use Closure;

class LastThirtyDaysFilter
{
    public function handle($query, Closure $next)
    {
        $date = Carbon::now()->subDays(30);
        if (!request()->has('last_thirty_days') OR request()->input('last_thirty_days')===false) {
            return $next($query);
        }
        return $next($query)->where('created_at', '>=', $date);
    }
}
