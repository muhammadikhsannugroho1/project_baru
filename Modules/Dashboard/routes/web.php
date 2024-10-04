<?php
namespace Modules\Dashboard\Http\Controllers;
use Illuminate\Support\Facades\Route;


Route::group(['prefix'=>'dashboard','as'=>'.dashboard'],function (){
    Route::get('/login',[LoginController::class,"login"])->name(".login");
});
