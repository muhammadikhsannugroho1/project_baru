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

