<?php

namespace Brand\Standard\Middleware;

use Brand\Standard\Exceptions\BrandForbiddentException;
use Brand\Standard\Exceptions\BrandUnauthorizedException;
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
        $request->offsetSet( 'RequestId' ,  makeRequestId() );

        //非白名单请求
        $routeName =$request->route() ? $request->route()->getName() : "";
        if( !in_array($routeName , configStandard('white_list_route_name') ))
        {
            //唯一token
            $requestToken =$request->header('Authorization');

            //优先校验Token合法性，并注入登录者信息
            $request->offsetSet( 'LoginUserInfo' ,  $this->getRequestUserInfo( $requestToken) );

            //权限校验
            if( !AdminService::hasRole('root') ){
                if( !AdminService::can( $routeName) ){
                    throw new BrandForbiddentException();
                }
            }

            //刷新用户登录过期时间
            Redis::expire( $requestToken , configStandard('token_expire') );

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
            throw new BrandUnauthorizedException();
        }

        return $useInfo;
    }
}
