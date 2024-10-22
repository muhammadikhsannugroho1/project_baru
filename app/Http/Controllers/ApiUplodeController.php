<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ApiUplodeController extends Controller
{
    public function create(){
        $respons=Http::post('http://127.0.0.1:8080/api/userresep');
        $UserResepTable=json_decode($respons->body());
        $data['data']=$UserResepTable->data;

        return view('auth.unggah',$data);
    }
    
    public function store(Request $request){
        $input = $request->input();
        try{
            $response=Http::post('http://127.0.0.1:8080/api/userresep',$input);
            $UserResepTable=json_decode($response->body());
            $data['data']=$UserResepTable?->data;
            return redirect(route('dashboard'));;
        }catch(\Exception $e){
            dd($e);

        }  
     }
}