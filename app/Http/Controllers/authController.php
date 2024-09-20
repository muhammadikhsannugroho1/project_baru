<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerUser(Request $request){
        // Aturan validasi
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ];

        // Proses validasi
        $validator = Validator::make($request->all(), $rules);
        
        if ($validator->fails()) {
            // Kembalikan respons jika validasi gagal
            return response()->json([
                'status' => false,
                'message' => 'Proses validasi gagal',
                'data' => $validator->errors()
            ], 400); // Status HTTP 400 untuk bad request
        }

        // Proses penyimpanan data jika validasi berhasil
        $datauser = new User();
        $datauser->name = $request->name;
        $datauser->email = $request->email;
        $datauser->password = Hash::make($request->password); // Hash password sebelum menyimpan
        $datauser->save();

        // Kembalikan respons setelah data berhasil disimpan
        return response()->json([
            'status' => true,
            'message' => 'Berhasil memasukkan data baru',
            'data' => $datauser
        ], 201); // Status HTTP 201 untuk resource created
    }
}
?>
