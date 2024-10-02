<?php

use App\Http\Controllers\adminController;
use App\Http\Controllers\authController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\userController;
use App\Http\Controllers\UserResepController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/',function(){
return response()->json([
    'status' =>false,
    'message'=>'akses tidak di perbolehkan'
],400);
});







Route::group(['prefix' => 'userresep', 'as' => 'api.userresep'], function () {
    Route::get('/', [UserResepController::class, 'index'])->name('index')->middleware('auth.sanctum');
    Route::get('/create', [UserResepController::class, 'create'])->name('create');
    Route::post('/', [UserResepController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [UserResepController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UserResepController::class, 'update'])->name('update');
    Route::get('/{id}', [UserResepController::class, 'show'])->name('show');
    Route::delete('/{id}', [UserResepController::class, 'destroy'])->name('destroy');
    Route::patch('/{id}/restore', [UserResepController::class, 'restore'])->name('restore');
});



Route::post('/registerUser', [AuthController::class, 'registerUser']);
Route::post('/loginUser', [AuthController::class, 'loginUser']);
// Route::post('/registeruser', [userController::class, 'registeruser']);
// Route::post('/login', [AuthController::class, 'login']);
// route::post('authController',[authController::class,'AuthController']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('users', [userController::class, 'index']);
//     Route::get('users/{id}', [userController::class, 'show']);
//     Route::put('users/{user}', [userController::class, 'update']);
// });
// Route::put('/admin/resep/{id}/approve', [AdminController::class, 'approve'])->middleware('auth:admin');
// Route::put('/admin/resep/{id}/reject', [AdminController::class, 'reject'])->middleware('auth:admin');

