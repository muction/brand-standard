<?php

namespace Brand\Standard\Middleware;

use Closure;
use Illuminate\Support\Facades\Route;


class BrandMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        if(!in_array($request->route()->getName()  , config('starspermission.whiteRouteNameList'))){
            //校验是否登录系统
            $this->validRequest( $request );
        }

        //注入登录人基本信息
        $request->offsetSet( 'loginUserInfo' , ['time'=>time()] );

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     */
    public function validRequest( $request ){
        $requestHeaderToken= $request->header('token');
        if( !$requestHeaderToken){
            throw new \Exception('非法请求');
        }elseif ( $requestHeaderToken && !tokenValidator($requestHeaderToken) ){
            throw new \Exception("TOKEN无效");
        }else{

        }
    }
}
