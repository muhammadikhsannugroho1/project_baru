<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ApiResepSayaController extends Controller
{
    public function resepSaya(Request $request)
    {
        // Ambil token user dari session
        $token = session('access_token'); // Pastikan token sudah tersimpan di session

        // Jika token tidak ada, arahkan ke halaman login
        if (!$token) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }

        try {
            // Panggil API dengan token
            $response = Http::withToken($token)->get('http://127.0.0.1:8081/api/resepsaya/tampilan');

            // Periksa apakah respons berhasil
            if ($response->successful()) {
                $data = $response->json(); // Konversi respons menjadi array atau object
                return view('auth.resepSaya', compact('data')); // Kirim data ke view
            } else {
                // Jika respons gagal, tangani error
                return view('auth.resepSaya', ['error' => 'Gagal mendapatkan data resep. Silakan coba lagi.']);
            }
        } catch (\Exception $e) {
            // Jika terjadi exception, tampilkan pesan error
            return view('auth.resepSaya', ['error' => 'Terjadi kesalahan saat memproses data: ' . $e->getMessage()]);
        }
    }

    public function delete($id)
{
    // Ambil token user dari session
    $token = session('access_token');

    // Jika token tidak ada, arahkan ke halaman login
    if (!$token) {
        return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
    }

    try {
        // Panggil API dengan token untuk menghapus resep, pastikan ID dipassing dengan benar
        $response = Http::withToken($token)->delete("http://127.0.0.1:8081/api/userresep/" . $id);

        // Periksa apakah penghapusan berhasil
        if ($response->successful()) {
            return redirect()->route('ResepSaya')->with('success', 'Resep berhasil dihapus.');
        } else {
            return redirect()->route('ResepSaya')->withErrors(['error' => 'Gagal menghapus resep.']);
        }
    } catch (\Exception $e) {
        return redirect()->route('ResepSaya')->withErrors(['error' => 'Terjadi kesalahan saat menghapus resep: ' . $e->getMessage()]);
    }
}

}
