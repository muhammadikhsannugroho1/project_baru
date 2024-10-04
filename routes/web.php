<?php

// routes/web.php
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