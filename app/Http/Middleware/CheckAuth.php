<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah token ada dan valid
        try {
            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['success' => false, 'message' => 'anda Perlu login'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'anda Perlu login'], 401);
        }

        return $next($request);
    }
}
