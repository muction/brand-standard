<?php
namespace Brand\Standard\Service;

use Brand\Standard\Response\Error;
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
            }])
            ->where('status', Error::STATUS_VALID )
            ->where('username', $username)
            ->select(['username' ,'password' ,'status' ,'id'])->first();
        if(!$user || $user && !Hash::check( $password, $user->password )){
            throw new \Exception(Error::APP_VALIDATOR_FAIL_MSG, Error::APP_VALIDATOR_FAIL_CODE );
        }
        $user = $user->toArray();
        $user['token'] = makeToken( $user['username'] . $user['password'] , date('Y-m-d-H:i:s') );
        $user['auth'] = self::separateUserPermission( $user ) ;
        unset($user['password'], $user['roles']);
        $hset= $user;
        $hset['auth'] = json_encode($hset['auth']);
        if(Redis::hmset( $user['token'] , $hset )){
            Redis::expire( $user['token'] , configStandard('token_expire') );
            return $user;
        }
        return false;
    }

    /**
     * 退出登录
     * @param $token
     * @return mixed
     */
    public function loginOut( $token ){

        return Redis::del( $token);
    }

    /**
     * 分离权限和菜单
     * @param array $user
     */
    private static function separateUserPermission( array $user){

        $permissions =[ 'menu'=>[] ,'action'=>[] ,'roles'=>[] ];
        foreach ($user['roles'] as $item ){
            $permissions['roles'][$item ['name']]= $item ['display_name'];
            foreach ($item['permissions'] as $er){
                if( $er['type'] == PermissionService::PERMISSION_TYPE_MENU_ID ){
                    $permissions['menu'][$er['name']] = $er['display_name'] ;
                }elseif ( $er['type'] == PermissionService::PERMISSION_TYPE_ACTION_ID){
                    $permissions['action'][$er['name']] =$er['display_name']  ;
                }
            }
        }

        return AdminService::parseUserPermission( $permissions );
    }
}
