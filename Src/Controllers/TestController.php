<?php
namespace Brand\Standard\Controllers;
use Brand\Standard\Requests\PostAdministrantorsRequest;
use Brand\Standard\Requests\RbacBranchRequest;
use Brand\Standard\Requests\RbacPermissionRequest;
use Brand\Standard\Requests\RbacRoleRequest;
use Brand\Standard\Service\AdminService;
use Brand\Standard\Service\BranchService;
use Brand\Standard\Service\LoginService;
use Brand\Standard\Service\PermissionService;
use Brand\Standard\Service\RoleService;
use Brand\Standard\Service\TestService;
use Illuminate\Http\Request;

/**
 * 后台管理控制器
 * Class AdminController
 * @package Brand\Standard\Controllers
 */
class TestController extends Controller
{
    public function index(Request $request , TestService $testService ){

        $action = $request->input('action' ,'test');

        if( method_exists( $testService, $action) ){
           return $this->responseSuccess(
               $testService->$action( $request )
           );
        }

    }

}
