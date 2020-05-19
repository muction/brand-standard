<?php
namespace Brand\Standard\Controllers;
use Brand\Standard\Requests\PostAdministrantorsRequest;
use Brand\Standard\Service\AdminService;
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


    // TODO 部门列表
    public function branch(){

    }
    // TODO 角色列表
    public function role(){

    }
    // TODO 权限列表
    public function permission(){

    }
}
