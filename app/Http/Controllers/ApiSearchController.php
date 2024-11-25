<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Countable;

class ApiSearchController extends Controller
{
    public function search(Request $request)
    {
        // Validasi query pencarian
        $request->validate([
            'query' => 'required|string|max:255',
        ]);
    
        // Ambil query dari input pencarian
        $query = $request->input('query');
    
        // Kirim request GET ke API dengan query pencarian
        $response = Http::get('http://127.0.0.1:8081/api/userresep/search', [
            'query' => $query, // Kirim query ke API
        ]);
    
        // Periksa apakah request berhasil
        if ($response->successful()) {
            // Decode hasil API
            $results = json_decode($response->body());
    
            // Pastikan properti 'data' ada dan berisi array
            if (isset($results->data) && is_array($results->data)) {
                return view('auth.search', ['results' => $results->data]);
            } else {
                // Jika tidak ada data, tampilkan pesan bahwa hasil tidak ditemukan
                return view('auth.search', ['results' => []]);
            }
        } else {
            // Jika request gagal, tampilkan pesan error
            return redirect()->back()->withErrors(['error' => 'Pencarian gagal. Silakan coba lagi.']);
        }
    }
    
}
