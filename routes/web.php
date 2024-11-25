<?php

// routes/web.php

use App\Http\Controllers\ApiDaftarMakananController;
use App\Models\Kategori;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

use function Laravel\Prompts\search;

Route::get('/', [\App\Http\Controllers\ApiDaftarMakananController::class, 'index'])->name('dashboard');
route::get('/show/{id}',[\App\Http\Controllers\ApiDaftarMakananController::class,'show'])->name('show');


Route::get('/login', [\App\Http\Controllers\ApiLoginController::class, 'showLoginForm'])->name('login'); // Menampilkan form login
Route::post('/login', [\App\Http\Controllers\ApiLoginController::class, 'Login']);
route::get('/logut',[\App\Http\Controllers\ApiLogoutController::class,'logout'])->name('logout');

// Menampilkan form registrasi
Route::get('/register', [\App\Http\Controllers\ApiRegister::class, 'show'])->name('register');

// Proses registrasi ketika form disubmit (gunakan POST, bukan GET)
Route::post('/register', [\App\Http\Controllers\ApiRegister::class, 'register']);


route::get('/uplode',[\App\Http\Controllers\ApiUplodeController::class,'create'])->name('uplode');
route::post('/uplode/store',[\App\Http\Controllers\ApiUplodeController::class,'store'])->name('store');
route::get('/profil',[\App\Http\Controllers\ApiProfilController::class,'profil'])->name('profil');
route::get('/resepsaya', [\App\Http\Controllers\ApiResepSayaController::class, 'resepSaya'])->name('ResepSaya');

Route::delete('/resep/{id}', [\App\Http\Controllers\ApiResepSayaController::class, 'delete'])->name('resep.delete');




route::get('/kategori',function() {
    return view('auth.kategori');
})->name('kategori');

route::get('/Kategori/minuman',[\App\Http\Controllers\ApiKategoriControllerMinuman::class,'ShowMinuman'])->name('minuman');
// route::get('/kategori/minuman/{id}',[\App\Http\Controllers\ApiKategoriControllerMinuman::class,'show'])->name('show');

route::get('/search',[\App\Http\Controllers\ApiSearchController::class,'search'])->name('search');

route::get('/Kategori/makanan',[\App\Http\Controllers\ApiControllerMakanan::class,'ShowMakanan'])->name('makanan');
// route::get('/kategori/makanan/{id}',[\App\Http\Controllers\ApiControllerMakanan::class,'show'])->name('show');


