<?php

use App\Http\Controllers\authController;
use App\Http\Controllers\resepController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => 'resep', 'as' => 'api.resep'], function () {
    Route::get('/', [resepController::class, 'index'])->name('index');
    Route::get('/create', [resepController::class, 'create'])->name('create');
    Route::post('/', [resepController::class, 'store'])->name('store');
    Route::get('/edit/{id_resep}', [resepController::class, 'edit'])->name('edit');
    Route::put('/{id_resep}', [resepController::class, 'update'])->name('update');
    Route::get('/{id_resep}', [resepController::class, 'show'])->name('show');
    Route::delete('/{id_resep}', [resepController::class, 'destroy'])->name('destroy');
    Route::patch('/{id_resep}/restore', [resepController::class, 'restore'])->name('restore');
});

route::post('registerUser',[authController::class,'registerUser']);
