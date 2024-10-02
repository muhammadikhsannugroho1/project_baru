<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResepResource;
use App\Models\UserResep;
use App\Models\userresep as ModelsUserresep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserResepController extends Controller
{
    public function index()
    {
        $data = UserResep::orderby('name', 'asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data
            
        ]);
    }

    public function store(Request $request)
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name'      => 'required|string|max:255',
            'deskripsi'  => 'required|string|max:255',
            'bahan'     => 'required|array',
            'pembuatan' => 'required|array',
            'kategori'  => 'required|in:makanan,minuman',
        ]);
    
        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Proses validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }
    
        // Membuat instance baru dari model UserResep
        $UserResep = new UserResep();
        $image = $request->file('image');
    
        // Simpan gambar dan ambil nama file
        $imagePath = $image->storeAs('public/UserResep', $image->hashName());
        $UserResep->image = basename($imagePath);
    
        // Set data lainnya
        $UserResep->name = $request->input('name');
        $UserResep->deskripsi = $request->input('deskripsi');
        $UserResep->bahan = json_encode($request->input('bahan')); // Mengonversi array ke JSON
        $UserResep->pembuatan = json_encode($request->input('pembuatan')); // Mengonversi array ke JSON
        $UserResep->kategori = $request->input('kategori');
        $UserResep->status = 'diproses';
    
        // Menyimpan data ke database
        $UserResep->save();
    
        // Mengembalikan response setelah data disimpan
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan',
            'data' => $UserResep
        ], 201);
    }
    

    public function update(Request $request, $id)
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'name'      => 'required|string',
            'deskripsi'  => 'required|string',
            'bahan'     => 'required|array',
            'pembuatan' => 'required|array',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'kategori'  => 'required|in:makanan,minuman',
        ]);
    
        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Proses validasi gagal',
                'errors' => $validator->errors()
            ], 400);
        }
    
        // Cari UserResep berdasarkan ID
        $UserResep = UserResep::findOrFail($id);
    
        // Cek apakah ada gambar yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($UserResep->image) {
                Storage::delete('public/UserResep/' . $UserResep->image);
            }
    
            // Simpan gambar baru dan ambil nama file
            $image = $request->file('image');
            $imagePath = $image->storeAs('public/UserResep', $image->hashName());
            $UserResep->image = basename($imagePath);
        }
    
        // Perbarui data UserResep lainnya
        $UserResep->name = $request->input('name');
        $UserResep->deskripsi = $request->input('deskripsi');
        $UserResep->bahan = json_encode($request->input('bahan')); // Mengonversi array ke JSON
        $UserResep->pembuatan = json_encode($request->input('pembuatan')); // Mengonversi array ke JSON
        $UserResep->kategori = $request->input('kategori');
    
        // Menyimpan perubahan data ke database
        $UserResep->save();
    
        // Mengembalikan response setelah data diperbarui
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $UserResep
        ], 200);
    }
    
    public function show($id)
    {
        // Validasi ID apakah integer
        $validator = Validator::make(['id' => $id], [
            'id' => 'required|integer',
        ]);
    
        // Cek apakah validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'ID tidak valid',
                'errors' => $validator->errors()
            ], 400);
        }
    
        // Cari UserResep berdasarkan ID
        $UserResep = UserResep::find($id);
    
        // Jika data tidak ditemukan, kembalikan response dengan data null
        if (!$UserResep) {
            return response()->json([
                'status' => true,
                'message' => 'Data tidak ditemukan',
                'data' => null
            ], 200); // Menggunakan status code 200 agar tetap sukses dengan data null
        }
    
        // Decode data 'pembuatan' hanya saat membacanya
        $pembuatan = json_decode($UserResep->pembuatan, true);
        $alat = json_decode($UserResep->alat, true);
        // Mengembalikan data yang ditemukan
        return response()->json([
            'status' => true,
            'message' => 'Detail data ditemukan',
            'data' => [
                'id' => $UserResep->id,
                'name' => $UserResep->name,
                'alat' => $alat,
                'bahan' => $UserResep->bahan,
                'pembuatan' => $pembuatan, // hasil sudah dalam bentuk array
                'kategori' => $UserResep->kategori,
                'status' => $UserResep->status,
                'image' => $UserResep->image,
            ]
        ]);
    }
    

//untuk menghapus
public function destroy($id)
{

    //find post by ID
    $UserResep = Userresep::find($id);

    //delete image
    Storage::delete('public/resep/'.basename($UserResep->image));

    //delete resep makanan
    $UserResep->delete();

    //return response
    return new UserResepResource(true, 'Data Post Berhasil Dihapus!', null);
}
}
