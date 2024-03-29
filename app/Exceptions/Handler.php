<?php

namespace App\Exceptions;

use App\Http\Responses\Responses;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if(strpos($exception->getMessage(),'count Disabled')){
            return Responses::respondError(trans('messages.activate_account'));
        }

        if(strpos($exception->getMessage(),'oken')){
            return Responses::respondOut($exception->getMessage());
        }        
        if(strpos($exception->getMessage(),'egments')){
            return Responses::respondOut($exception->getMessage());
        }

        return parent::render($request, $exception);
    }
}
