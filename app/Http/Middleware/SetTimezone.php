<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetTimezone
{
    public function handle(Request $request, Closure $next)
    {
        date_default_timezone_set('America/New_York');
        return $next($request);
    }
}
