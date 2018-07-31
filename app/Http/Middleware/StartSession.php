<?php

namespace App\Http\Middlewarecd;

use Closure;

class StartSession
{
    public function handle($request, Closure $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
// Store the session data...
    }
}