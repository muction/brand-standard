<?php
namespace Brand\Standard\Service;

use Rbac\Standard\Entity\RbacGroup;
use Rbac\Standard\Entity\RbacRole;
use Illuminate\Http\Request;


class RoleService
{
    /**
     * 分页
     * @param Request $request
     * @return mixed
     */
    public function index( Request $request ){

        return RbacRole::orderByDesc('updated_at')
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

        $name = $request->input('name') ;
        $displayName = $request->input('display_name') ;
        $rbacRole = new RbacRole();
        return $rbacRole->storage( $name , $displayName );
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

    public function bindPermission(Request $request, $roleId ){

        $rbacRole = new RbacRole();
        $info = $rbacRole->info( $roleId );
        if(!$info){
            throw new  \Exception("角色没有找到");
        }

        $permissions =
        $info->bindPermissions( $permissions );
        return $info;
    }
}
