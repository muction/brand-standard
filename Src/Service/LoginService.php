<?php
namespace Brand\Standard\Service;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Rbac\Standard\Entity\RbacPermission;
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

        $user= RbacUser::with(['roles.permissions'=>function($query){
            $query->select('rbac_permissions.id','type','parent_id','name' ,'display_name' ,'order');
        },'groups'])
            ->where('username', $username)
            ->select(['username' ,'password' ,'status' ,'id'])->first();
        if(!$user || $user && !Hash::check( $password, $user->password )){
            throw new \Exception("用户名密码错误~");
        }
        $user = $user->toArray();
        $user['token'] = self::makeUserLoginToken( $user['username'] , $user['password'] );
        unset($user['password']);
        //TODO 加入权限配置，菜单配置
        $user['menus'] = RbacPermission::where( 'type',1)->orderByDesc('order')->get();



        //设置为登录状态
        if(Redis::hmset( $user['token'] , $user )){
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
        return strtoupper( md5( $username . $password ) ) ;
    }
}
