<?php
namespace Brand\Standard\Service;

use Rbac\Standard\Entity\RbacGroup;
use Rbac\Standard\Entity\RbacPermission;
use Rbac\Standard\Entity\RbacRole;
use Illuminate\Http\Request;


class PermissionService
{
    /**
     * 分页
     * @param Request $request
     * @return mixed
     */
    public function index( Request $request ){

        return RbacPermission::orderByDesc('updated_at')
            ->paginate( $request->input('size', 20 ) );
    }

    /**
     * 新增一个
     * @param Request $request
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function storage( Request $request , $id ){
        if(!$id ){
            return $this->create(  $request );
        }else{
           return $this->modify( $request , $id );
        }

    }

    /**
     * 新增一个
     * @param Request $request
     * @return mixed
     */
    private function create( Request $request ){

        $type = $request->input('type') ;
        $name = $request->input('name') ;
        $displayName = $request->input('display_name') ;
        $rbacPermission = new RbacPermission();
        return $rbacPermission->storage( $type , $name , $displayName );
    }

    /**
     * @param Request $request
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    private function modify( Request $request ,int $id ){

        $name = $request->input('name') ;
        $displayName = $request->input('display_name') ;
        $rbacRole = new RbacRole();
        $info = $rbacRole->info( $id );
        if(!$info){
            throw new  \Exception("角色没有找到");
        }
        $info->name = $name ;
        $info->display_name = $displayName;
        $info->save();
        return $info;
    }

    /**
     * 删除
     * @param int $id
     * @return bool
     */
    public function remove( int $id ){
        $rbacRole = new RbacRole();
        $info = $rbacRole->info( $id );
        if( $info){
            $info->delete();
        }
        return $info;
    }

    /**
     * 绑定权限
     * @param Request $request
     * @param $roleId
     * @return mixed
     * @throws \Exception
     */
    public function bindPermission(Request $request, $roleId ){

        $rbacRole = new RbacRole();
        $info = $rbacRole->info( $roleId );
        if(!$info){
            throw new  \Exception("角色没有找到");
        }

        $permissions = $request->input('permissions') ;
        $info->deletePermissions( null );
        $info->bindPermissions( $permissions );
        return $info;
    }
}
