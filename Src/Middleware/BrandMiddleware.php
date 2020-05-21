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

        //注入RequestId
        $request->offsetSet( 'RequestId' , md5( microtime(true). rand(1,9999 )) );

        //非白名单请求
        if( !in_array( $request->route()->getName()  ,configStandard('white_list_route_name') ) ){
            $request->offsetSet( 'LoginUserInfo' ,
                $this->getRequestUserInfo( $request->header('Authorization') )
            );
        }

        return $next($request);
    }

    /**
     * 校验登录Token 是否有效： 无效（过期，无用户） 有效（有用户且未过期）
     * @param $requestHeaderToken
     * @return bool
     * @throws \Exception
     */
    private function getRequestUserInfo( $requestHeaderToken ){

        if(!$requestHeaderToken || $useInfo= !Redis::hgetAll( $requestHeaderToken )){
            throw new \Exception( "无效的Token");
        }

        return $useInfo;
    }
}
