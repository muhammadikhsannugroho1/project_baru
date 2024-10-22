<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;


use Illuminate\Http\Request;

class ApiDaftarMakananController extends Controller
{

    public function index()
    {
        
        $respons = Http::get('http://127.0.0.1:8080/api/userresep');
        $userresep=json_decode($respons->body());
        //dd($userresep);
        $data['data']=$userresep->data;
        //dd($data);
        return view('auth.dashboard',$data);
    }

    public function show() {
        $respons= Http::put('http://127.0.0.1:8080/api/userresep/:id');
        $userresep=json_decode($respons->body());
    }
}
