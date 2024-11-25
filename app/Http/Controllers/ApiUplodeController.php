<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class ApiUplodeController extends Controller
{
    public function create(){
        $respons=Http::post('http://127.0.0.1:8081/api/userresep');
        $UserResepTable=json_decode($respons->body());
        // dd($UserResepTable);
        $data['data']=$UserResepTable->data;
        
        //dd(session('access_token'));
        return view('auth.unggah',$data);
    }
    
    
    public function store(Request $request) {
        // Validasi input
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);
    
        // Ambil semua input kecuali file
        $input = $request->except('image');
        $arr=[];
        foreach($input as $key=>$val){
            $arr[]=["name"=>$key,"content"=>$val];
            
            
            
        }
        $input=$arr;
        //dd($arr);
        $uplode=[

        ];
        //dd($input, $request->file('image'));
        
        try {
            $image = $request->file('image');
            //return file_get_contents($image->getPathname());
            //exit;
            //dd(file_get_contents($image->getPathname()));
            //if (!$image) {
                //return redirect()->back()->withErrors(['error' => 'File gambar tidak ditemukan.']);
            //}
            // Ambil token dari session
            $session = session('access_token');
           // dd($session);
            if (!$session) { dd('a');
                return redirect()->back()->withErrors(['error' => 'Token tidak ditemukan.']);
            }
    
            // Kirim POST request dengan attach file sebagai multipart
            $response = Http::withToken($session)
         ->attach(
             'image', //Pastikan nama field ini cocok dengan yang diharapkan API
             file_get_contents($image->getRealPath())
             //$image->getClientOriginalName()
             )
        ->post('http://127.0.0.1:8081/api/userresep', $input);
    
            // Cek jika upload berhasil
            if ($response->successful()) {
                $UserResepTable = json_decode($response->body());
    
                if (isset($UserResepTable->data)) {
                    return redirect(route('dashboard'))->with('status', 'Resep berhasil di-upload!');
                }
                dd('Gagal upload resep.');
                return redirect()->back()->withErrors(['error' => $UserResepTable->message ?? 'Gagal upload resep.']);
            }
            dd('Gagal mengunggah ke server.',$response->body());
            return redirect()->back()->withErrors(['error' => 'Gagal mengunggah ke server.']);
        } catch (\Exception $e) {
            // Tangani exception jika terjadi error
            dd($e); 
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat meng-upload resep.']);
        }  
    }
}