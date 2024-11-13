<?php

namespace App\Http\Controllers;
use Cloudinary\Cloudinary;
use Cloudinary\Transformation\Transformation;
use App\Http\Resources\UserResepResource;
use App\Models\userResep;
use App\Models\userresep as ModelsUserresep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


class UserResepController extends Controller
{
    public function index()
    {
        // Mengambil resep dengan status 'diterima' saja dan melakukan pagination
        $UserResep = UserResep::where('status', 'diterima')
            ->select('id', 'name', 'image', 'kategori')
            ->paginate(2); // Menampilkan 10 data per halaman
    
        // Menambahkan padding pada ID
        $UserResep->getCollection()->transform(function ($item) {
            $item->id = str_pad($item->id, 4, '0', STR_PAD_LEFT);
            return $item;
        });
    
        return response()->json([
            'success' => true,
            'data' => $UserResep
        ]);
    }
    



public function store(Request $request)
{
    // Cek apakah pengguna sudah login
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'code' => 'S01',
            'message' => 'perlu login',
            'data' => null
        ], 401);
    }

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
    $imagePath = $image->storeAs('posts', $image->hashName(), 'public'); 
    $UserResep->image = $image->hashName(); // Simpan hanya nama filenya saja

    // Set data lainnya
    $UserResep->name = $request->input('name');
    $UserResep->deskripsi = $request->input('deskripsi');
    $UserResep->bahan = json_encode($request->input('bahan')); // Mengonversi array ke JSON
    $UserResep->pembuatan = json_encode($request->input('pembuatan')); // Mengonversi array ke JSON
    $UserResep->kategori = $request->input('kategori');
    $UserResep->status = 'diproses';

    // Mendapatkan ID pengguna yang sedang login
    $user = Auth::user();
    $UserResep->user_id = $user->id; // Menetapkan user_id ke resep

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
            ], 401);
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
        ], 401);
    }

    // Cari UserResep berdasarkan ID
    $UserResep = UserResep::find($id);

    // Jika data tidak ditemukan, kembalikan response dengan data null
    if (!$UserResep) {
        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan',
            'data' => null
        ], 401); // Menggunakan status code 200 agar tetap sukses dengan data null
    }

    // Decode data 'pembuatan' dan 'bahan' hanya saat membacanya
    $pembuatan = json_decode($UserResep->pembuatan, true);
    $bahan = json_decode($UserResep->bahan, true);

    // Mengubah ID menjadi objek
    $idObj = ['id' => str_pad($UserResep->id, 4, '0', STR_PAD_LEFT)];

    // Mengembalikan data dengan ID sebagai objek
    return response()->json([
        'status' => true,
        'message' => 'Detail data ditemukan',
        'data' => [
            'id' => $idObj,  // ID menjadi objek
            'name' => $UserResep->name,
            'bahan' => $bahan,
            'pembuatan' => $pembuatan,
            'kategori' => $UserResep->kategori,
            'image' => $UserResep->image,
            'deskripsi' => $UserResep->deskripsi,
        ]
    ]);
}

    
    
    

    //untuk menghapus
    public function destroy($id)
{
    $user = Auth::user();

    // Mencari resep berdasarkan ID
    $UserResep = UserResep::where('id', $id)->where('user_id', $user->id)->first();

    if (!$UserResep) {
        return response()->json([
            'status' => false,
            'message' => 'Resep tidak ditemukan atau Anda tidak memiliki hak untuk menghapus resep ini.'
        ], 401);
    }

    // Hapus gambar jika ada
    Storage::delete('public/resep/' . basename($UserResep->image));

    // Hapus resep
    $UserResep->delete();

    return response()->json([
        'status' => true,
        'message' => 'Data resep berhasil dihapus!'
    ]);
}

    

    //untuk mencari/search resep makanan
    public function search(Request $request)
    {
        $query = $request->input('query'); // Ambil parameter query dari request
    //    
        // Validasi jika query tidak ada
        if (!$query) {
            return response()->json(['success' => false, 'message' => 'Query is required'], 400);
        }

       
    $UserResep = userResep::where('status', 'diterima')
    ->where('name', 'LIKE', "%{$query}%")  
    ->get();

        return response()->json(['success' => true, 'data' => $UserResep]);
    }


    //untuk user melihat resep nya sendiri/untuk cek status diterima/ditolak
    public function showresepSaya(Request $request)
    {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();
        $resepSaya = UserResep::where('user_id', $user->id)->get();
        // Mengambil resep yang dibuat oleh pengguna tersebut
        $resepSaya = UserResep::where('user_id', $user->id)->get();
      // Cek apakah ada resep
      if ($resepSaya->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan'
        ], 404);
    }
        return response()->json([
            'success' => true,
            'data' => $resepSaya
        ]);
    }
    public function filterkategori(Request $request)
    {
        // Mendapatkan kategori dari input
        $kategori = $request->input('kategori');
    
        // Mengambil resep berdasarkan kategori dan status
        $UserResep = UserResep::where('kategori', $kategori)
            ->where('status', 'diterima')
            ->get(['id','name','image','kategori']);
    
        // Cek apakah resep ditemukan
        if ($UserResep->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'data' => []
            ], 404);
        }
    
        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $UserResep
        ]);
    }
    public function tampilanresepSaya(Request $request)
{
    // Mendapatkan pengguna yang sedang login
    $User = Auth::user();

    // Mengambil resep yang dibuat oleh pengguna tersebut, hanya mengambil field yang dibutuhkan
    $resepSaya = UserResep::where('user_id', $User->id)
                          ->select('id', 'name', 'image') // Hanya ambil kolom name, image, kategori, dan id untuk detail
                          ->get();

    // Cek apakah ada resep
    if ($resepSaya->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'Data tidak ditemukan'
        ], 401);
    }

    return response()->json([
        'success' => true,
        'data' => $resepSaya
    ]);
}
    
  

}


