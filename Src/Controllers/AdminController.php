<?php
namespace Brand\Standard\Controllers;
use Brand\Standard\Requests\PostAdministrantorsRequest;
use Brand\Standard\Service\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 后台管理控制器
 * Class AdminController
 * @package Brand\Standard\Controllers
 */
class AdminController extends Controller
{
    // TODO 管理员列表
    public function administrators(){

    }

    public function administratorsStorage(PostAdministrantorsRequest $request){

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
