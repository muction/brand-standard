<?php
namespace Brand\Standard\Controllers;
use Brand\Standard\Requests\PostAdministrantorsRequest;
use Brand\Standard\Requests\RbacBranchRequest;
use Brand\Standard\Requests\RbacPermissionRequest;
use Brand\Standard\Requests\RbacRoleRequest;
use Brand\Standard\Service\AdminService;
use Brand\Standard\Service\BranchService;
use Brand\Standard\Service\PermissionService;
use Brand\Standard\Service\RoleService;
use Illuminate\Http\Request;

/**
 * 后台管理控制器
 * Class AdminController
 * @package Brand\Standard\Controllers
 */
class AdminController extends Controller
{
    /**
     * 管理员列表
     * @param Request $request
     * @param AdminService $adminService
     * @return array
     */
    public function administrators(Request $request, AdminService $adminService){

        return $this->responseSuccess(
            $adminService->index( $request )
        );
    }


    /**
     *  用户仅绑定 角色和部门 的关系数据
     * @param PostAdministrantorsRequest $request
     * @param AdminService $adminService
     * @return array
     * @throws \Exception
     */
    public function administratorsStorage(PostAdministrantorsRequest $request ,AdminService $adminService ){

        return $this->responseSuccess(
            $adminService->adminStorage( $request ,0 )
        );
    }

    /**
     * 编辑用户
     * @param Request $request
     * @param AdminService $adminService
     * @param $userId
     * @return array
     * @throws \Exception
     */
    public function administratorsModify(Request $request, AdminService $adminService , $userId ){

        $adminService->userIsValidator( $request, $userId );
        return $this->responseSuccess(
            $adminService->adminStorage( $request , $userId )
        );
    }

    /**
     * 删除一个用户
     * @param AdminService $adminService
     * @param $userId
     * @return array
     */
    public function administratorsRemove(AdminService $adminService , $userId ){
        return $this->responseSuccess(
            $adminService->adminRemove( $userId )
        );
    }


    /**
     * 部门列表
     * @param Request $request
     * @param BranchService $branchService
     * @return array
     */
    public function branch( Request $request , BranchService $branchService ){
        return $this->responseSuccess(
            $branchService->index( $request )
        );
    }

    /**
     * 新增
     * @param RbacBranchRequest $request
     * @param BranchService $branchService
     * @return array
     * @throws \Exception
     */
    public function branchStorage(RbacBranchRequest $request , BranchService $branchService  ){
        return $this->responseSuccess(
            $branchService->branchStorage( $request , 0)
        );
    }

    /**
     * 修改
     * @param RbacBranchRequest $request
     * @param BranchService $branchService
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function branchModify( RbacBranchRequest $request , BranchService $branchService , $id  ){
        return $this->responseSuccess(
            $branchService->branchStorage( $request , $id )
        );
    }

    /**
     * @param BranchService $branchService
     * @param $id
     * @return array
     */
    public function branchRemove( BranchService $branchService ,$id ){
        return $this->responseSuccess(
            $branchService->remove( $id )
        );
    }


    /**
     * 角色列表
     * @param Request $request
     * @param RoleService $roleService
     * @return array
     */
    public function role(Request $request , RoleService $roleService){
        return $this->responseSuccess(
            $roleService->index( $request )
        );
    }

    /**
     * @param RbacRoleRequest $request
     * @param RoleService $roleService
     * @return array
     * @throws \Exception
     */
    public function roleStorage(RbacRoleRequest $request , RoleService $roleService){
        return $this->responseSuccess(
            $roleService->storage( $request , 0 )
        );
    }

    /**
     * @param RbacRoleRequest $request
     * @param RoleService $roleService
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function roleModify(RbacRoleRequest $request , RoleService $roleService , $id ){
        return $this->responseSuccess(
            $roleService->storage( $request , $id )
        );
    }

    /**
     * 删除
     * @param RoleService $roleService
     * @param $id
     * @return array
     */
    public function roleRemove(RoleService $roleService , $id ){
        return $this->responseSuccess(
            $roleService->remove( $id )
        );
    }

    /**
     * 角色绑定Group
     * @param Request $request
     * @param RoleService $roleService
     * @param $roleId
     * @return array
     * @throws \Exception
     */
    public function roleBindPermission( Request $request , RoleService $roleService , $roleId ){
        return $this->responseSuccess(
            $roleService->bindPermission( $request, $roleId )
        );
    }

    /**
     * 权限列表
     * @param RbacPermissionRequest $request
     * @param PermissionService $permissionService
     * @return array
     */
    public function permission(Request $request, PermissionService $permissionService){

        return $this->responseSuccess(
            $permissionService->index( $request )
        );
    }


    /**
     * 新增权限
     * @param PermissionService $permissionService
     * @return array
     * @throws \Exception
     */
    public function permissionStorage( RbacPermissionRequest $request , PermissionService $permissionService){

        return $this->responseSuccess(
            $permissionService->storage( $request ,0 )
        );
    }

    /**
     * 修改
     * @param RbacPermissionRequest $request
     * @param PermissionService $permissionService
     * @param $id
     * @return array
     * @throws \Exception
     */
    public function permissionModify( RbacPermissionRequest $request , PermissionService $permissionService , $id){

        return $this->responseSuccess(
            $permissionService->storage( $request ,$id )
        );
    }

    /**
     * 删除
     * @param PermissionService $permissionService
     * @param $id
     * @return array
     */
    public function permissionRemove( PermissionService $permissionService , $id){

        return $this->responseSuccess(
            $permissionService->remove( $id )
        );
    }
}
