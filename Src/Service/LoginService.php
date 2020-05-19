<?php
namespace Brand\Standard\Service;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Rbac\Standard\Traits\RbacUser;

class LoginService
{
    /**
     * @param $username
     * @param $password
     * @return mixed
     * @throws \Exception
     */
    public function authLogin( $username, $password){

        $user= RbacUser::where('username', $username)
            ->select(['username' ,'password' ,'status'])->first();
        if(!$user || $user && !Hash::check( $password, $user->password )){
            throw new \Exception("用户名密码错误~");
        }

        // 不保存密码
        unset( $user->password );

        $user->token = self::makeUserLoginToken( $user->username , $user->passwrod );

        $hasLoginUserInfo = Redis::hgetAll( $user->token );
        if( $hasLoginUserInfo ){
            return $hasLoginUserInfo;
        }

        //设置为登录状态
        if(Redis::hmset( $user->token , $user->toArray() )){
            //dump( Redis::ttl( $user->token ) );
            return $user;
        }

        return false;
    }

    /**
     * 生成登录Token
     * @param $username
     * @param $password
     * @return string
     */
    public static function makeUserLoginToken( $username, $password ){
        return md5( $username . $password );
    }
}
