<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserResep;
class AdminController extends Controller
{
    // Mengambil semua pengguna
   public function index()
{
    // $this->authorize('viewAny', User::class);
    return response()->json(User::all(), 200);
}


    // Menghapus pengguna
    public function destroy(User $user)
    {
        // $this->authorize('delete', $user);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully'], 200);
    }

    // Fungsi untuk menyetujui resep
    public function approve($id)
    {
        // Temukan resep berdasarkan ID
        $UserResep = UserResep::findOrFail($id);

        // Ubah status menjadi diterima
        $UserResep->status = 'diterima';
        $UserResep->save();

        return response()->json([
            'status' => true,
            'message' => 'Resep berhasil diterima',
            'data' => $UserResep
        ], 200);
    }

    // Fungsi untuk menolak resep
    public function reject($id)
    {
        // Temukan resep berdasarkan ID
        $UserResep = UserResep::findOrFail($id);

        // Ubah status menjadi ditolak
        $UserResep->status = 'ditolak';
        $UserResep->save();

        return response()->json([
            'status' => true,
            'message' => 'Resep berhasil ditolak',
            'data' => $UserResep
        ], 200);
    }
}

