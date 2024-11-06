<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class ApiDaftarMakananController extends Controller
{

    public function index()
    {
        
        $respons = Http::get('http://127.0.0.1:8081/api/userresep');
        $userresep=json_decode($respons->body());
        //dd($userresep);
        $data['data']=$userresep->data;
        //dd($data);
        return view('auth.dashboard',$data);
    }

    public function show($id) {
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
