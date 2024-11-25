<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ApiRegister extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(Request $request)
{
    // Validasi input dari form
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'password' => 'required|string|min:8|confirmed', // Konfirmasi password
    ]);

    // Ambil data dari form
    $data = [
        'name' => $request->input('name'),
        'email' => $request->input('email'),
        'password' => $request->input('password'),
        'password_confirmation' => $request->input('password_confirmation'),
    ];

    // Kirim request POST ke API untuk registrasi
    $response = Http::post('http://127.0.0.1:8081/api/register', $data);
    $user = json_decode($response->body());

    // Cek apakah registrasi berhasil
    if ($response->successful() && isset($user->success) && $user->success === true) {
        // Redirect ke halaman sukses
        return redirect()->route('register.success');
    } else {
        // Tampilkan error jika registrasi gagal
        return redirect()->back()->withErrors(['error' => $user->message ?? 'Registrasi gagal.']);
    }
}

}

