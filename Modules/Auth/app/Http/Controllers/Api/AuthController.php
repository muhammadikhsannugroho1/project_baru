<?php

namespace Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Http\Requests\RegisterRequest;

class AuthController extends ApiBaseController {
  public function __construct(){
    parent::__construct();
    $this->middleware('auth:api', [
      'except' => ['login','register','verifyEmail','reVerifyEmail','emailForgotPassword','recoveryPassword']
    ]);
  }

  public function login(Request $request){
    $request->validate([
      'email' => 'required|string',
      'password' => 'required|string',
    ]);
    $credentials= $request->only('email', 'password');
    try {
      $token = auth()->attempt($credentials);
      if (!$token) {
        return $this->sendError('Wrong password or username', '',202,'S01-202');
      }
      $user = auth()->user();
      /*if(!$user->email_verified_at){
        return $this->sendError('You need to confirm your account. please check your email.', '',202);
      }*/

      $user['token'] = $token;
      $user['token_type']='bearer';

      return $this->sendResponse($this->createNewToken($token), 'Login successfully.',200,'S01-200');
    }catch (\Exception $e){
      return throw $e;
    }
  }

  public function passwordUpdate(Request $request){
    $input = $request->input();
    $user = Auth::user();
    if(Hash::check($input['new_password'],$user->getAuthPassword())){
      return $this->sendError('The new password cannot be the same as the old password','',202,'S01-202');
    }

    if(Hash::check($input['password'],$user->getAuthPassword())){
      $user->password = Hash::make($input['new_password']);
      $user->save();
      return $this->sendResponse(null,'Password changed successfully',202,'S01-202');
    }

    /*dd(
      $input, $user,$user->getAuthPassword(),
      Hash::check($input['new_password'],$user->getAuthPassword())
    );*/

  }
  public function register(RegisterRequest $request){
    $input = $request->all();
    $input['name']=$input['full_name'];
    $input['password'] = bcrypt($input['password']);

    DB::beginTransaction();
    $iEmailVerify=[];
    try {
      $mUser = User::create($input);
      $mProfile = new Profiles();
      $input['id'] = $mUser->id;
      $iProfile = $mProfile::transformPayload($input);
      $mProfile::create($iProfile);

      $mEmailVerify = new EmailVerifies();
      $httpOrigin = $request->header('Origin',config('app.url'));
      $iEmailVerify['email'] = $mUser->email;
      $iEmailVerify['token'] =  hash('sha256',Str::random(40));
      $iEmailVerify['expire_at']=Carbon::now()->addHours(24)->timestamp;
      $iEmailVerify['origin'] =$httpOrigin;
      $oEmailVerify= $mEmailVerify::create([
        "email"=>$mUser->email,
        'token'=>hash('sha256',Str::random(40)),
        'expire_at'=>Carbon::now()->addHours(24)->timestamp,
        'flag'=>"verify",
        'origin'=>$httpOrigin
      ]);
      $dataEmail = [
        'name'=>$mUser->name,
        'email'=>$mUser->email,
        'url'=>$httpOrigin.'/email-verify/'.$oEmailVerify->id.'/'.$oEmailVerify->token
      ];
      $sendEmail = new RegisterMail($dataEmail);

      DB::commit();
      if(!config('app.send_mail')){
        return $this->sendResponse(null, 'Tautan aktifasi telah dikirim ke email '.$mUser->email);
        return $sendEmail->render();
      }
      Mail::to($mUser->email)->send($sendEmail);
      return $this->sendResponse(null, 'Tautan aktifasi telah dikirim ke email '.$mUser->email);
    }catch (\Exception $e){
      DB::rollback();
      return $this->sendError(null, 'GAGAL.');
    }
  }

  public function verifyEmail($id,$token){
    if($email = EmailVerifies::find($id)){
      if($email->token != $token) {return $this->sendError(null,'Tautan Tidak Terdaftar',202);}
      $now    = Carbon::now()->timestamp;
      $expire = $email->expire_at;
      if($now > $expire){return $this->sendError(null,'Tautan Sudah Expire, Silahkan genarate ulang',202);}
      $user = User::where(['email'=>$email->email])->first();
      if($user->hasVerifiedEmail()) {return $this->sendResponse(null,'Tautan sudah digunakan');}
      if($user->markEmailAsVerified()) {event(new Verified($user));}
      return $this->sendResponse(null,'email berhasil di verifikasi');
    }
    return $this->sendError(null,'Tautan Tidak Terdaftar',404);
  }

  public function reVerifyEmail(Request $request){
    $request->validate(['email'=>['required','email','max:255']]);
    $httpOrigin = $request->header('Origin',config('app.url'));

    $mEmail = new EmailVerifies();
    if($mEmailVerify = $mEmail::where(["email"=>$request->email])->first()){
      $now    = Carbon::now()->timestamp;
      $expire = $mEmailVerify->expire_at;
      if($now > $expire){
        DB::beginTransaction();
        try {
          $iEmail['email'] = $mEmailVerify->email;
          $iEmail['token'] =  hash('sha256',Str::random(40));
          $iEmail['expire_at']=Carbon::now()->addHours(12)->timestamp;
          $iEmail['origin'] =$httpOrigin;
          $oEmail = $mEmail::create($iEmail);
          $mEmailVerify->forcedelete();
          $dataEmail = ['email'=>$mEmailVerify->email, 'url'=>$httpOrigin.'/email-verify/'.$oEmail->id.'/'.$oEmail->token];
          $sendEmail = new ReVerifyMail($dataEmail);
          DB::commit();
          if(!config("app.send_mail")){return $sendEmail->render();}
          Mail::to($mEmailVerify->email)->send($sendEmail);
          return $this->sendResponse(null, 'tautan aktifasi telah dikirim ke e-mail '.$mEmailVerify->email);
        }catch (\Exception $e){
          DB::rollBack();
          //return $e->getMessage();
          throw new $e('Ada kesalahan, silahkan hubungi web administrator',406);
        }
      }else{return $this->sendError(null,'Tautan masih berlaku, tidak bisa digenarate',406);}
    }
    return $this->sendError(null,'Email tidak terdaftar',406);
  }

  public function emailForgotPassword(Request $request){
    $request->validate(['email'=>['required','email','max:255']]);
    $httpOrigin = $request->header('Origin',config('app.url'));
    $nUser = new User();
    $mEmail = new EmailVerifies();
    if($mUser = $nUser::where(["email"=>$request->email])->first()){
      DB::beginTransaction();
      try {
        $oEmail = $mEmail::create([
          "email"=>$mUser->email,
          'token'=>hash('sha256',Str::random(40)),
          'expire_at'=>Carbon::now()->addHours(24)->timestamp,
          'flag'=>"forgot-password",
          'origin'=>$httpOrigin
        ]);
        $sendEmail = new ForgotPasswordMail([
          'name'=>$mUser->name,
          'email'=>$mUser->email,
          'url'=>$httpOrigin.'/recovery-password/'.$oEmail->id.'/'.$oEmail->token
        ]);
        DB::commit();
        if(!config("app.send_mail")){return $sendEmail->render();}
        Mail::to($mUser->email)->send($sendEmail);
        return $this->sendResponse(null, 'Tautan Perubahan Password telah dikirim ke e-mail '.$mUser->email);
      }catch (\Exception $e){
        DB::rollBack();
        //return $e->getMessage();
        throw new $e('Ada kesalahan, silahkan hubungi web administrator',406);
      }
    }
    return $this->sendError(null,'Email tidak terdaftar',406);
  }

  public function recoveryPassword(Request $request,$id,$token){
    $request->validate([
      'password'=> ['required','max:255', Password::min(8)->mixedCase()->numbers()->symbols()]
    ]);
    if($mEmail = EmailVerifies::find($id)){
      if($mUser = User::where(['email'=>$mEmail->email])->first()){
        if($mEmail->token != $token || $mEmail->flag!="forgot-password"){
          return $this->sendError(null,'Tautan Tidak Terdaftar',202);
        }
        $iPassword = bcrypt($request->password);
        DB::beginTransaction();
        try {
          $mUser->password = $iPassword;
          $mUser->save();
          $sendEmail = new ChangePassByForgotPassNotifMail([
            'name'=>$mUser->name,
            'email'=>$mUser->email,
            'url'=>$mEmail->origin.'/recovery-password/'.$mEmail->id.'/'.$mEmail->token
          ]);
          DB::commit();
          if(!config("app.send_mail")){return $sendEmail->render();}
          Mail::to($mUser->email)->send($sendEmail);
          return $this->sendResponse(null, 'Kata sandi berhil diubah '.$mUser->email);
        }catch (\Exception $e){
          DB::rollBack();
          //return $e->getMessage();
          throw new $e('Ada kesalahan, silahkan hubungi web administrator',406);
        }
      }else{throw new ModelNotFoundException();}
    }return $this->sendError(null,'Tautan Tidak Terdaftar',404);
  }

  public function createNewToken($token){
    return [
      'access_token'=>$token,
      'token_type'=>'bearer',
      'expire_at'=>auth()->guard('api')->factory()->getTTL() * 60
    ];
  }

  public function refresh(){
    return $this->sendResponse(
      $this->createNewToken(auth()->guard('api')->refresh()),
      "Refresh token",200,'S01-200');
  }

  public function logout(){
    auth()->guard('api')->logout();
    return $this->sendResponse(null,"Logout",200,'SO1-200');

  }
}
