<?php

namespace Brand\Standard\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;
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
        $configWriteListRouteName = configStandard('white_list_route_name') ;
        $requestRouteName =$request->route()->getName() ;
        if( in_array( $requestRouteName ,$configWriteListRouteName ? $configWriteListRouteName : [] ) ){
            \Log::info( 'request_write_list_route_name' , [$requestRouteName , $configWriteListRouteName]);
        }else{
            $request->offsetSet( 'loginUserInfo' ,
                $this->isValidRequestToken( $request->header('Authorization') )
            );
        }
        return $next($request);
    }

    /**
     * TODO 校验登录Token 是否有效： 无效（过期，无用户） 有效（有用户且未过期）
     * @param $requestHeaderToken
     * @return bool
     * @throws \Exception
     */
    private function isValidRequestToken( $requestHeaderToken ){

        if(!$requestHeaderToken || $useInfo= !Redis::hgetAll( $requestHeaderToken )){
            throw new \Exception( "无效的Token");
        }

        return $useInfo;
    }
}
