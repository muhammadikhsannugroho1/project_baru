<?php

namespace App\Http\Controllers;

use App\Models\UserResep; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 

class AdminController extends Controller
{
    public function acceptRecipe($id)
    {
        
        $user = Auth::user();

      
        if ($user->role !== 'admin') {
            return response()->json(['status' => false, 'message' => 'Unauthorized, only admin can access this route.'], 403);
        }

       
        $recipe = UserResep::find($id);

        if (!$recipe) {
            return response()->json(['status' => false, 'message' => 'Resep tidak ditemukan'], 404);
        }

       
        $recipe->status = 'diterima';
        $recipe->save();

        return response()->json(['status' => true, 'message' => 'Resep diterima', 'data' => $recipe]);
    }

    public function rejectRecipe($id)
    {
       
        $user = Auth::user();

       
        if ($user->role !== 'admin') {
            return response()->json(['status' => false, 'message' => 'Unauthorized, only admin can access this route.'], 403);
        }

       
        $recipe = UserResep::find($id);

        if (!$recipe) {
            return response()->json(['status' => false, 'message' => 'Resep tidak ditemukan'], 404);
        }

        $recipe->status = 'ditolak';
        $recipe->save();

        return response()->json(['status' => true, 'message' => 'Resep ditolak', 'data' => $recipe]);
    }
}
