<?php
namespace Brand\Standard\Service;

use Rbac\Standard\Entity\RbacGroup;
use Rbac\Standard\Entity\RbacPermission;
use Rbac\Standard\Entity\RbacRole;
use Illuminate\Http\Request;

class TestService
{

    /**
     * 默认Test 调试方法输出
     */
    public function test(){

        dd( 'default test method '.date('Y-m-d H:i:s'));
    }

    /**
     * debug 权限
     * @param Request $request
     * @param PermissionService $permissionService
     */
    public function debugPermission(Request $request ){

        if(!env('APP_DEBUG')){
            return [];
        }

        dd( AdminService::loginUser($request->input('token')));
        return RbacPermission::orderBy('name','ASC')
            ->get(['id','type','name','display_name','status','created_at']);
    }
}
