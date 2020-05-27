<?php
namespace Brand\Standard\Service;

use Brand\Standard\Exceptions\BrandNotFoundException;
use Brand\Standard\Response\Error;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Rbac\Standard\Traits\RbacUser;
use Illuminate\Http\Request;


class AdminService
{
    /**
     * 分页获取所有管理员
     * @param Request $request
     * @return mixed
     */
    public function index( Request $request ){

        return RbacUser::orderByDesc('updated_at')
            ->where('status', Error::STATUS_VALID )
            ->select(['id' ,'username' ,'created_at' ,'updated_at'])
            ->paginate( $request->input('size', 20 ) );
    }

    /**
     * 新增一个用户
     * @param Request $request
     * @param $userId
     * @return mixed
     * @throws \Exception
     */
    public function adminStorage( Request $request , $userId ){


        if(!$userId){
            return $this->createUser(  $request );
        }else{
           return $this->modifyUser( $request , $userId );
        }

    }

    /**
     * 新增一个用户
     * @param Request $request
     * @return mixed
     */
    private function createUser( Request $request ){

        $postRoles = $request->input('roles');
        $postBranch = $request->input('branch');
        $userName = $request->input('username') ;
        $password = $request->input('password') ;
        $status = $request->input('status');
        $rbacUser = new RbacUser();
        $user = $rbacUser->storage( $userName , $password , $status);
        if( $postRoles ){
            $user->bindRoles( $postRoles );
        }
        if( $postBranch ){
            $user->bindGroups( $postBranch );
        }

        return $user;
    }

    /**
     * @param Request $request
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    private function modifyUser( Request $request ,int $id ){

        try{
            DB::beginTransaction();

            $user = RbacUser::with(['roles','groups'])->where('id' , $id)->first();
            if(!$user){
                throw new \Exception( "用户不存在");
            }

            $password = $request->input('password') ;
            $status = $request->input('status');
            $user->password = Hash::make( $password );
            $user->status = $status ;
            $user->save();

            $postRoles = $request->input('roles');
            $postBranch = $request->input('branch');

            $user->deleteGroups( null);
            if($postBranch){
                $user->bindGroups( $postBranch );
            }

            $user->deleteRoles( null);

            if($postRoles){
                $user->bindRoles( $postRoles );
            }

            DB::commit();

            return true ;
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info( 'MODIFY_ADMIN_SERVICE_MODIFY_USER_EXCEPTION' , ['msg'=>$exception->getMessage() , 'user_id'=>$id]);
            return false;
        }
    }

    /**
     * 删除一个用户，同时删除绑定角色，绑定组
     * @param int $id
     * @return bool
     */
    public function adminRemove( int $id ){

        //不能本人删本人
        if( $id == self::loginUser( 'id') ){
            throw new \Exception(Error::APP_ULTRA_VIRES_MSG , Error::APP_ULTRA_VIRES_CODE);
        }

        try{
            DB::beginTransaction();

            $user = RbacUser::with(['roles','groups'])->where('id' , $id)->first();
            if(!$user){
                throw new BrandNotFoundException();
            }
            $user->deleteGroups( null);
            $user->deleteRoles( null);
            $user->delete();
            DB::commit();

            return true ;
        }catch (\Exception $exception){
            DB::rollBack();
            Log::info( 'MODIFY_ADMIN_SERVICE_ADMIN_REMOVE_EXCEPTION' , ['msg'=>$exception->getMessage() , 'user_id'=>$id]);
            return false;
        }
    }

    /**
     * 验证用户有效性
     * @param Request $request
     * @param $id
     * @return bool
     * @throws \Exception
     */
    public function userIsValidator(Request $request , $id){
        $userPassword = RbacUser::where('id' , $id)->value('password');
        if(!$userPassword){
            throw new BrandNotFoundException();
        }

        if( !Hash::check( $request->input('old_password') , $userPassword ) ){
            throw new \Exception(Error::APP_ORIGIN_PASSWORD_ERROR_MSG , Error::APP_ORIGIN_PASSWORD_ERROR_CODE );
        }
        return true ;
    }

    /**
     * 获取登陆者信息
     * @return mixed
     */
    public static function loginUser( $key =null ){
        $all= Redis::hgetall( loginUserToken() );
        if( isset($all['auth']) && $all['auth']){
            $all['auth'] = json_decode($all['auth'], true );
        }

        if($key){
            return isset($all[$key]) ? $all[$key] : null;
        }

        return $all;
    }

    /**
     * 解析Json权限
     * @param $permissions
     * @return array
     */
    public static function parseUserPermission(array $permissions ){
        $all =[];
        $all['menu_names'] = is_array($permissions['menu'] ) ? array_keys($permissions['menu'] ) : [];
        $all['action_names'] = is_array($permissions['action']) ? array_keys($permissions['action'] ) : [];
        $all['role_names'] = is_array($permissions['roles']) ? array_keys($permissions['roles'] ) :[];
        $all['permissions'] = $permissions;
        return $all ;
    }

    /**
     * 是否有权限
     * @param array|string $permission
     * @return bool
     */
    public static function hasPermission( $permission ){

        if($loginUserPermission=self::loginUser() ){
            if(is_array($permission)){
                return array_intersect( $permission, $loginUserPermission['auth']['action_names'] ) ? true : false;
            }elseif ( is_string($permission)){
                return in_array( $permission, $loginUserPermission['auth']['action_names'] );
            }
        }
        return false;
    }

    /**
     * 是否授权某个角色
     * @param array|string $role
     * @return bool
     */
    public static function hasRole( $role ){
        if( $loginUserPermission=self::loginUser() ){
            if(is_array($role)){
                return array_intersect( $role, $loginUserPermission['auth']['role_names'] ) ? true : false;
            }elseif ( is_string($role)){
                return in_array( $role, $loginUserPermission['auth']['role_names'] );
            }
        }
        return false;
    }

    /**
     * 是否可以操作
     * @param string $permission
     * @return bool
     */
    public static function can(string $permission ){
        if($loginUserPermission=self::loginUser() ){
            return in_array( $permission, $loginUserPermission['auth']['action_names'] );
        }
        return false;
    }
}
