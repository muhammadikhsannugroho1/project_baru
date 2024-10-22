<?php
use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\AuthController;

Route::group(['prefix'=>'auth','as'=>'.auth'],function (){
    Route::post('/login',[AuthController::class,'login'])->name('.login');
});

Route::middleware("auth:api")->group(function () {
    Route::group(['prefix'=>'auth','as'=>'.auth'],function (){
        Route::post('/refresh',[AuthController::class,'refresh'])->name('.refresh');
        Route::post('/logout',[AuthController::class,'logout'])->name('.logout');
        Route::post('/password-update',[AuthController::class,'passwordUpdate'])->name('.password-update');
    });
});
