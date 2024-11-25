<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiResepSayaController extends Controller
{
    public function resep(){
        return view('auth.resepSaya');
    }
}
