<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

class ApiLoginController extends Controller
{
    public function showLoginForm() {
        if(session('access_token')){
            return redirect('/');
        }
        $ref = request()->query('referer')??null;
        return view('auth.login',['ref'=>$ref]); // Menampilkan view login
    }

    public function Login(Request $request) {
        // Validasi input terlebih dahulu
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Ambil data dari input setelah validasi
        $credentials = [
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ];
    
        // Kirim request ke API login
        $response = Http::post('http://127.0.0.1:8081/api/v1/auth/login', $credentials);
        $user = json_decode($response->body());
    
        // Cek jika login berhasil berdasarkan properti `success` dari respons API
        //dd($response->successful(),isset($user->success),$user->success === true,isset($user->data->token),($user->data));
        if ($response->successful() && isset($user->success) && $user->success === true && isset($user->data->access_token)) {
            // Simpan token di sesi jika login berhasil
            //dd('hahah');
            session(['access_token' => $user->data->access_token]);
            if($request->referer){
                return redirect($request->referer);
            }
            
            return redirect()->route('uplode');  // Arahkan ke halaman upload
        } else {
            // Jika login gagal, tampilkan pesan error dari API
            $errorMessage = $user->message ?? 'Login gagal. Cek email atau password.';
            return redirect()->back()->withErrors(['error' => $errorMessage]);
        }
    }
    
}
