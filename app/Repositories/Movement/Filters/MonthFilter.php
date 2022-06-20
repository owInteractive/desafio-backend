<?php
namespace App\Repositories\Movement\Filters;

use Closure;

class MonthFilter
{
    public function handle($query, Closure $next)
    {
        if (!request()->has('month') AND request()->input('month')!=='') {
            return $next($query);
        }
        $date = explode('-', request()->input('month'));
        return $next($query)->whereMonth('created_at', $date[1])->whereYear('created_at', $date[0]);
    }
}
