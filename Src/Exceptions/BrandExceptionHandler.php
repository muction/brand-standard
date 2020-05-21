<?php

namespace Brand\Standard\Exceptions;

use Brand\Standard\Exceptions\BrandApiRequestErrorException;
use Brand\Standard\Requests\ResponseTrait;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class BrandExceptionHandler extends ExceptionHandler
{
    use ResponseTrait;

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
     * @param  Request  $request
     * @param  \Throwable  $exception
     * @return mixed
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        $getPrefix = $request->route() ? $request->route()->getPrefix() : null;
        if( strtolower($getPrefix) ==  configStandard('route_prefix') ){
            return $this->responseError( [],
                $exception->getMessage() ,
                $exception->getCode()
            );
        }
        return parent::render($request, $exception);
    }
}
