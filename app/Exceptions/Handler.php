<?php

namespace App\Exceptions;

use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Client\ConnectionException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            // TODO
        });
    }

  public function render($request, Throwable $e){
    $eClass     = get_class($e);
    $eMessages  = $e->getMessage() ?? "Undefined";
    $httpCode = 406;
    $code       = 'S01';
    $devCode       = 406;
    if($e->getCode()!=0){$code = $e->getCode();}
    $eData      = "";
    if (!$request->bearerToken()){ $eMessages = 'bearerToken Not found';}
    if ($eClass===AuthenticationException::class){ $eMessages ="Not Authentication";$httpCode=403;}
    if ($eClass===NotFoundHttpException::class){$eMessages ="Route Not Found";}
    if ($eClass===QueryException::class){
      $eMessages ="Database Error";
      $httpCode = 500;
      $code = 'S02-001';
      $devCode = $e->getCode();
    }
    if ($eClass===ModelNotFoundException::class){
      $eMessages ="Data not found.";$httpCode=202;
    }
    if($eClass===ConnectionException::class){
      $code = 'S02-002';
      $eMessages ="Redis Disconnected.";;
    }
    if ($eClass==ValidationException::class){
      $eData      = $e->validator->errors();
      $eMessages  = $e->getMessage();
      $httpCode=202;
    }
    $response['success']  = false;
    $response['code']  = $code;
    // if($devCode){$response['dev_code'] = $devCode;}
    $response['message']=$eMessages;
    $response['data']=null;
    if($eData){$response['data']  = $eData;}

    if(config('app.debug')==true){
      $response['app_debug']=[
        'class'=>" Global:".$eClass,
        'error'=>$e->getMessage() ?? "Undefined",
        'file'=>$e->getFile()??null,
        'line'=>$e->getLine()??null,
      ];
    }
    $response['time']=Carbon::now()->timestamp;
    //dd($e);
    return response()->json($response,$httpCode);
  }

}
