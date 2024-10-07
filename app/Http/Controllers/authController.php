<?php

// namespace App\Http\Controllers;

// use App\Models\User;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Support\Facades\Hash;

// class AuthController extends Controller
// {
//     public function registerUser(Request $request)
//     {
//         // Aturan validasi
//         $rules = [
//             'name' => 'required',
//             'email' => 'required|email|unique:users,email',
//             'password' => 'required|min:6',
//         ];

//         // Validasi input
//         $validator = Validator::make($request->all(), $rules);
//         if ($validator->fails()) {
//             return response()->json([
//                 'status' => false,
//                 'message' => 'Proses validasi gagal',
//                 'data' => $validator->errors()
//             ], 401);
//         }

//         // Membuat instance baru dari User
//         $datauser = new User();
//         $datauser->name = $request->input('name');
//         $datauser->email = $request->input('email');
//         $datauser->password = Hash::make($request->input('password'));

//         // Menyimpan data user ke database
//         $datauser->save();

//         return response()->json([
//             'status' => true,
//             'message' => 'Berhasil menambahkan data baru'
//         ], 200);
//     }
//     public function loginUser(Request $request)
// {
//     $rules = [
//         'email' => 'required|email',
//         'password' => 'required|min:6',
//     ];

//     // Validasi input
//     $validator = Validator::make($request->all(), $rules);
//     if ($validator->fails()) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Proses login gagal',
//             'data' => $validator->errors()
//         ], 401);
//     }

//     // Mengautentikasi pengguna
//     if (!Auth::attempt($request->only(['email', 'password']))) {
//         return response()->json([
//             'status' => false,
//             'message' => 'Email dan password tidak sesuai'
//         ], 400);
//     }

//     // Mendapatkan pengguna yang sedang login
//     $datauser = Auth::user(); // Ambil pengguna yang sedang login

//     // Membuat token untuk pengguna
//     $token = $datauser->createToken('api-resepmakan')->plainTextToken;

//     return response()->json([
//         'status' => true,
//         'message' => 'Berhasil proses login',
//         'token' => $token // Mengembalikan token
//     ], 200);
// }

    
// }
