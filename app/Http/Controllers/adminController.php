<?php
namespace App\Http\Controllers;

use App\Models\UserResep; // Pastikan Anda menggunakan model yang benar
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function acceptRecipe($id)
    {
        $recipe = UserResep::find($id);

        if (!$recipe) {
            return response()->json(['status' => false, 'message' => 'Resep tidak ditemukan'], 404);
        }

        $recipe->status = 'diterima'; // Mengubah status menjadi 'diterima'
        $recipe->save();

        return response()->json(['status' => true, 'message' => 'Resep diterima']);
    }

    public function rejectRecipe($id)
    {
        $recipe = UserResep::find($id);

        if (!$recipe) {
            return response()->json(['status' => false, 'message' => 'Resep tidak ditemukan'], 404);
        }

        $recipe->status = 'ditolak'; // Mengubah status menjadi 'ditolak'
        $recipe->save();

        return response()->json(['status' => true, 'message' => 'Resep ditolak']);
    }
}
?>
