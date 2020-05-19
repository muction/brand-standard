<?php
namespace Brand\Standard\Service;

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
            ->where('status', 1)
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
            $user->bindGroups( $postBranch );

            $user->deleteRoles( null);
            $user->bindRoles( $postRoles );

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
        try{
            DB::beginTransaction();

            $user = RbacUser::with(['roles','groups'])->where('id' , $id)->first();
            if(!$user){
                throw new \Exception( "用户不存在");
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

}
