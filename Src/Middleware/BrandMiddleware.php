<?php

namespace Brand\Standard\Middleware;

use Brand\Standard\Exceptions\BrandForbiddentException;
use Brand\Standard\Service\AdminService;
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
        $request->offsetSet( 'RequestId' , strtoupper( md5( microtime(true). rand(1,9999 )) ) );

        //非白名单请求
        $routeName =$request->route() ? $request->route()->getName() : "";
        if( !in_array( $routeName ,configStandard('white_list_route_name') ) ){
            $request->offsetSet( 'LoginUserInfo' ,
                $this->getRequestUserInfo( $request->header('Authorization') )
            );

            //刷新用户登录过期时间
            Redis::expire( $request->header('Authorization'), configStandard('token_expire') );

            //权限,系统中每个RouteName都视为一个权限
            if(!AdminService::can( $routeName)){
                throw new BrandForbiddentException();
            }
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
