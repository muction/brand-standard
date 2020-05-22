<?php
namespace Brand\Standard\Service;

use Rbac\Standard\Entity\RbacGroup;
use Rbac\Standard\Entity\RbacPermission;
use Rbac\Standard\Entity\RbacRole;
use Illuminate\Http\Request;


class PermissionService
{
    /**
     * 权限类型--菜单
     */
    const PERMISSION_TYPE_MENU_ID = 1;

    /**
     * 权限类型--动作
     */
    const PERMISSION_TYPE_ACTION_ID = 2;

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
     * @return mixed
     */
    public function debugPermission(){

        if(!env('APP_DEBUG')){
            return [];
        }
        return RbacPermission::orderBy('name','ASC')->get(['id','type','name','display_name']);
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
        }
        return $this->modify( $request , $id );
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
        $parentId = $request->input('parent_id') ;
        $order = $request->input('order') ;
        $rbacPermission = new RbacPermission();
        return $rbacPermission->storage( $type , $name , $displayName ,$parentId , $order);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    private function modify( Request $request ,int $id ){

        $name = $request->input('name') ;
        $parentId = $request->input('parent_id') ;
        $order = $request->input('order') ;
        $displayName = $request->input('display_name') ;
        $rbacRole = new RbacPermission();
        $info = $rbacRole->info( $id );
        if(!$info){
            throw new  \Exception("角色没有找到");
        }
        $info->name = $name ;
        $info->display_name = $displayName;
        $info->parent_id = $parentId;
        $info->order = $order;
        $info->save();
        return $info;
    }

    /**
     * 删除
     * @param int $id
     * @return bool
     */
    public function remove( int $id ){
        $rbacRole = new RbacPermission();
        $info = $rbacRole->info( $id );
        if( $info){
            $info->delete();
        }
        return $info;
    }

}
