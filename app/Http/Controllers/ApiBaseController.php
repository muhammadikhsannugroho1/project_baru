<?php
namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

class ApiBaseController extends Controller{
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
  public function __construct(){
    auth()->setDefaultDriver("api");
  }
  
  public function sendResponse($result, $message, $code = 200 , $devCode='S01'){
    $response = [
      'success' => true,
      'code' => $devCode,
      'message' => $message,
      'data'    => $result,
      'time'=>Carbon::now()->timestamp,
      

    ];
    return response()->json($response, $code);
  }
  
  public function sendError($error, $errorMessages = [], $code = 404,$devCode='S01'){
    $response['success']=false;
    $response['code']=$devCode;
    $response['message']=$error;
    $response['time']=Carbon::now()->timestamp;
    if($errorMessages==''){$errorMessages=null;}
    if( is_array($errorMessages)){if(count($errorMessages)==0){$errorMessages=null;}}
    $response['data'] = $errorMessages;
    if(!empty($errCode)){$response['devCode'] = $errCode;}
    return response()->json($response, $code);
  }
  
}
