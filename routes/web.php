<?php

// routes/web.php

use App\Http\Controllers\ApiDaftarMakananController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.dashboard');
})->name('dasboard');

route::get('/daftar', function(){
    return view('auth.daftar');
})->name('daftar');

route::get('/login', function () {
    return view('auth.login');
})->name('login');

route::get('/register',function() {
    return view('auth.register');
})->name('register');

route::get('/uplode',function() {
    return view('auth.unggah');
})->name('uplode');

route::get('/kategori',function() {
    return view('auth.kategori');
})->name('kategori');

// route::get('/register',function() {
//     return view('auth.register');
// })
 
// Route::get('/daftar', [ApiDaftarMakananController::class, 'index'])->name('index');