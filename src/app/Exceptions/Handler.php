<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $response_unknown = config('constants.RESPONSE_CODE_BODY.UNKNOWN');
        $response_miss_token = config('constants.RESPONSE_CODE_BODY.UNAUTHEN');
        
        if ( $exception instanceof \Illuminate\Database\QueryException) {
            $response_unknown['msg'] = 'QueryException: unknown error';
            return response()->json($response_unknown, $response_unknown['code']);
        } else if ( $exception instanceof \ErrorException) {
            $response_unknown['msg'] = 'ErrorException: unknown error';
            return response()->json($response_unknown, $response_unknown['code']);
        } 
        
        if ($exception instanceof \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException) {
            $preException = $exception->getPrevious();
            if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                $response_miss_token['msg'] = 'Token has expired';
                return response()->json($response_miss_token, $response_miss_token['code']);
            } else if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                $response_miss_token['msg'] = 'Token is invalid';
                return response()->json($response_miss_token, $response_miss_token['code']);
            } else if ($preException instanceof \Tymon\JWTAuth\Exceptions\TokenBlacklistedException) {
                $response_miss_token['msg'] = 'Token is blacklist';
                return response()->json($response_miss_token, $response_miss_token['code']);
           }
           if ($exception->getMessage() === 'Token not provided') {
                $response_miss_token['msg'] = 'Token not provided';
                return response()->json($response_miss_token, $response_miss_token['code']);
           }
        }

        return parent::render($request, $exception);
    }
}
