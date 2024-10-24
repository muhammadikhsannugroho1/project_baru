<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\authController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\userController;
use App\Http\Controllers\UserResepController;
use App\Http\Middleware\CheckAuth;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/',function(){
    return response()->json([
        'status' => false,
        'message' => 'Akses tidak di perbolehkan'
    ], 400);
});

// Route untuk akses gambar tanpa middleware autentikasi
Route::get('/storage/posts/{filename}', function ($filename) {
    $path = storage_path('app/public/posts/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
})->name('image.show');

// untuk resep
Route::group(['prefix' => 'userresep', 'as' => 'api.userresep'], function () {
    Route::get('/', [UserResepController::class, 'index'])->name('index');
    Route::get('/create', [UserResepController::class, 'create'])->name('create')->middleware('auth:api');
    Route::get('/filterkategori', [UserResepController::class, 'filterkategori'])->name('filterkategori');

    Route::get('/edit/{id}', [UserResepController::class, 'edit'])->name('edit')->middleware('auth:api');
    Route::put('/{id}', [UserResepController::class, 'update'])->name('update')->middleware('auth:api');
    Route::get('/search', [UserResepController::class, 'search'])->name('search');
    Route::get('/{id}', [UserResepController::class, 'show'])->name('show');
    Route::get('/kategori/{kategori}', [UserResepController::class, 'filterkategori'])->name('filterkategori');
    Route::delete('/{id}', [UserResepController::class, 'destroy'])->name('destroy')->middleware('auth:api');
    Route::patch('/{id}/restore', [UserResepController::class, 'restore'])->name('restore')->middleware('auth:api');
});

Route::group(['middleware' => [CheckAuth::class]], function () {
    Route::post('/userresep', [UserResepController::class, 'store']);
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/resepsaya/tampilan', [UserResepController::class, 'tampilanresepsaya']);
    Route::get('/resepsaya/show', [UserResepController::class, 'showresepSaya']);
});


// untuk register admin/user
Route::post('register', [UserController::class, 'register']);
Route::post('registerAdmin', [UserController::class, 'adminRegister']);

// untuk melihat profile


// untuk si admin memproses ditolak/diterima
Route::middleware('jwt.auth')->group(function () {
    Route::put('/resipes/{id}/accept', [AdminController::class, 'acceptRecipe']);
    Route::put('/resipes/{id}/reject', [AdminController::class, 'rejectRecipe']);
});
