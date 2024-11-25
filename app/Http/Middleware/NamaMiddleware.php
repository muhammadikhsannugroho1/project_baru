<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class NamaMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->header('X-Header') !== 'ValidValue') {
            return response('Unauthorized', 401);
        }
    
        return $next($request);
    }
    
}
