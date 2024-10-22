<?php

namespace App\Http\Controllers;

use App\Models\UserResep; // Pastikan Anda menggunakan model yang benar
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Import Facade Auth

class AdminController extends Controller
{
    public function acceptRecipe($id)
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Cek apakah user adalah admin
        if ($user->role !== 'admin') {
            return response()->json(['status' => false, 'message' => 'Unauthorized, only admin can access this route.'], 403);
        }

        // Mencari resep berdasarkan ID
        $recipe = UserResep::find($id);

        if (!$recipe) {
            return response()->json(['status' => false, 'message' => 'Resep tidak ditemukan'], 404);
        }

        // Mengubah status menjadi 'diterima'
        $recipe->status = 'diterima';
        $recipe->save();

        return response()->json(['status' => true, 'message' => 'Resep diterima', 'data' => $recipe]);
    }

    public function rejectRecipe($id)
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Cek apakah user adalah admin
        if ($user->role !== 'admin') {
            return response()->json(['status' => false, 'message' => 'Unauthorized, only admin can access this route.'], 403);
        }

        // Mencari resep berdasarkan ID
        $recipe = UserResep::find($id);

        if (!$recipe) {
            return response()->json(['status' => false, 'message' => 'Resep tidak ditemukan'], 404);
        }

        // Mengubah status menjadi 'ditolak'
        $recipe->status = 'ditolak';
        $recipe->save();

        return response()->json(['status' => true, 'message' => 'Resep ditolak', 'data' => $recipe]);
    }
}
