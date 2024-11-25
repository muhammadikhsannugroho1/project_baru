<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ApiProfilController extends Controller
{
    public function profil()
{
    // Ambil token dari session atau storage (sesuaikan dengan implementasimu)
    $token = session('access_token'); // Pastikan token disimpan di session
    //dd($token);
    if (!$token) {
        // Jika token tidak ada, arahkan ke halaman login
        return redirect()->route('login')->with('error', 'Anda harus login terlebih dahulu.');
    }

    // Kirim request ke API dengan header Authorization
    $response = Http::withToken($token)->get('http://127.0.0.1:8081/api/profile');

    // Cek apakah respons sukses
    //dd($response->body());
    if ($response->successful()) {
        $profil = $response->json(); // Parse respons ke array

        // Cek apakah data profil ada
        if (isset($profil['data'])) {
            // Kirim data profil ke view
            return view('auth.profil', [
                'name' => $profil['data']['name'],
                'email' => $profil['data']['email'],
            ]);
        }
    }

    // Jika respons gagal atau data tidak ditemukan
    return redirect()->route('login')->with('error', 'Gagal mengambil data profil. Silakan login ulang.');
}

}
