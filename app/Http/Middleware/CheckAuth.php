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
                return response()->json([
                    'success' => false,
                    'message' => 'anda perlu login',
                    'data' => null // Menambahkan 'data' dengan nilai null
                ], 401); // Kode status 401 Unauthorized
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'anda perlu login',
                'data' => null // Menambahkan 'data' dengan nilai null
            ], 401); // Kode status 401 Unauthorized
        }

        return $next($request);
    }
}

// Kenapa harus ada dua respon yang sama di if dan catch?

// Respon yang sama muncul di dua tempat (if dan catch) karena ada dua skenario di mana pengecekan token bisa gagal:
// Skenario 1 (di dalam if): Token ada, tetapi tidak valid atau tidak dapat diotentikasi (misalnya, user yang terkait dengan token tidak ditemukan).
// Skenario 2 (di dalam catch): Ada error atau exception yang dilemparkan saat mencoba memproses token (misalnya, token tidak ada sama sekali, token rusak, atau token kadaluarsa).