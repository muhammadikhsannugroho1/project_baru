<?php

namespace App\Http\Controllers;

use App\Http\Resources\resepResource;
use App\Models\resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class resepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = resep::orderby('name','asc')->get();
        return response()->json([
            'status' => true,
            'message' => 'data di temukan',
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    //define validation rules
    // Validasi data input
    $validator = Validator::make($request->all(), [
        'image'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'name' => 'required|string|max:255',
        'alat' => 'required|string|max:255',
        'bahan' => 'required|string|max:255',
        'pembuatan' => 'required|string',
    ]);

    // Cek apakah validasi gagal
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Proses validasi gagal',
            'errors' => $validator->errors()
        ], 400);
    }

    // Membuat instance baru dari model Resep
    $resep = new resep();
    $image = $request->file('image');

    if ($image) {
        // Simpan gambar dan ambil nama file
        $imagePath = $image->storeAs('public/resep', $image->hashName());
        // Simpan nama file gambar ke dalam model
        $resep->image = basename($imagePath);
    }

    $resep->name = $request->input('name');
    $resep->alat = $request->input('alat');
    $resep->bahan = $request->input('bahan');
    $resep->pembuatan = $request->input('pembuatan');

    // Menyimpan data ke database
    $resep->save();

    // Mengembalikan response setelah data disimpan
    return response()->json([
        'status' => true,
        'message' => 'Data berhasil disimpan',
        'data' => $resep
    ], 201);

    //return response
    return new resepResource(true, 'Data Kelas Berhasil Ditambahkan!', $resep);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        {
            //find post by ID
            $resep = resep::find($id);
    
            //return single post as a resource
            return new resepResource(true, 'Detail Data Post!', $resep);
        }
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, resep $resep)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(resep $resep)
    {
        //
    }
}
