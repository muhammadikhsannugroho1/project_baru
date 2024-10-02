<?php 
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class UserController extends Controller
{
    // Mengambil semua pengguna
    public function index()
    {
        // Hanya admin yang dapat mengakses ini
        // $this->authorize('viewAny', User::class);
        return response()->json(User::all(), 200);
        
    }

    // Menampilkan detail pengguna
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    // Memperbarui pengguna
    public function update(Request $request, User $user)
    {
        // $this->authorize('update', $user);

        // Validasi dan update pengguna
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'sometimes|in:user,admin',
        ]);

        $user->update($request->only('name', 'email', 'role'));

        return response()->json($user, 200);
    }
}
