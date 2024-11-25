<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiLogoutController extends Controller
{
    public function logout(){
        //dd(request()->server('HTTP_REFERER'));
        session()->flush();
        return redirect('login?referer='.request()->server('HTTP_REFERER'));
    }
}
