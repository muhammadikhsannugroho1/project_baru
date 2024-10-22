<?php

// routes/web.php

use App\Http\Controllers\ApiDaftarMakananController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::get('/', [\App\Http\Controllers\ApiDaftarMakananController::class, 'index'])->name('dashboard');
route::get('/show/{id}',[\App\Http\Controllers\ApiDaftarMakananController::class,'show'])->name('show');
route::get('/profil', function(){
    return view('auth.profil');
})->name('profil');

route::post('/login', [\App\Http\Controllers\ApiLoginController::class,'login'])->name('login');

route::get('/register',function() {
    return view('auth.register');
})->name('register');

route::get('/uplode',[\App\Http\Controllers\ApiUplodeController::class,'create'])->name('uplode');
route::post('/uplode/store',[\App\Http\Controllers\ApiUplodeController::class,'store'])->name('store');


route::get('/kategori',function() {
    return view('auth.kategori');
})->name('kategori');


