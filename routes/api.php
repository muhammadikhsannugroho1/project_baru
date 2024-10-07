<?php

use App\Http\Controllers\AdminController;
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
    Route::get('/', [UserResepController::class, 'index'])->name('index');
    Route::get('/create', [UserResepController::class, 'create'])->name('create');
    Route::post('/', [UserResepController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [UserResepController::class, 'edit'])->name('edit');
    Route::put('/{id}', [UserResepController::class, 'update'])->name('update');
    Route::get('/search', [UserResepController::class, 'search'])->name('search');
    Route::get('/{id}', [UserResepController::class, 'show'])->name('show');
    Route::delete('/{id}', [UserResepController::class, 'destroy'])->name('destroy');
    Route::patch('/{id}/restore', [UserResepController::class, 'restore'])->name('restore');
   
});



// Route::post('/registerUser', [AuthController::class, 'registerUser']);
// Route::post('/loginUser', [AuthController::class, 'loginUser']);

Route::post('register', [UserController::class, 'register']);
Route::post('registerAdmin', [UserController::class, 'adminRegister']);

Route::middleware('jwt.auth')->group(function () {
    Route::put('/resipes/{id}/accept', [AdminController::class, 'acceptRecipe']);
    Route::put('/resipes/{id}/reject', [AdminController::class, 'rejectRecipe']);

});


