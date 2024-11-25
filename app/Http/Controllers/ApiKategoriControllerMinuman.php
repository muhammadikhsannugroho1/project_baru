<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class ApiKategoriControllerMinuman extends Controller{
    public function ShowMinuman(){
        $response = Http::get('http://localhost:8081/api/userresep/filterkategori?kategori=minuman');
       
        $kategori = json_decode($response->body());
    
        // Menyimpan data kategori di dalam array $data
        $data = [
            'kategori' => $kategori->data ?? []
        ];
    
        return view('auth.Minuman', $data);
    }

    public function show($id){
         // Panggil API menggunakan metode GET
         $response = Http::get("http://127.0.0.1:8081/api/userresep/$id");

         // Memeriksa apakah permintaan berhasil
         if ($response->successful()) {
             $data = $response->json(); // Mengonversi respons JSON ke array
             
             // Pastikan untuk mengakses data di dalam array "data"
             $userData = $data['data'] ?? []; // Ambil data
 
             // Mengambil nilai dari userData
             $name = $userData['name'] ?? 'Nama tidak ditemukan';
             $bahan = $userData['bahan'] ?? []; // Ini adalah array
             $pembuatan = $userData['pembuatan'] ?? []; // Ini adalah array
             $kategori = $userData['kategori'] ?? 'Kategori tidak ditemukan';
             $imageUrl = $userData['image'] ?? ''; // Mengambil URL gambar
             $deskripsi = $userData['deskripsi']??'';
 
         } else {
             // Jika API gagal
             $name = 'Permintaan gagal, status: ' . $response->status();
             $bahan = [];
             $pembuatan = [];
             $kategori = 'Tidak ada kategori';
             $imageUrl = ''; // Kosongkan jika permintaan gagal
         }
 
         // Mengembalikan view dengan data yang diperlukan
         return view('auth.show', compact('name', 'bahan', 'pembuatan', 'kategori', 'imageUrl','deskripsi'));
     }
}