<?php
namespace Brand\Standard\Controllers;
use Brand\Standard\Requests\LoginRequest;
use Brand\Standard\Service\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * 登录服务，返回Token
 * Class LoginController
 * @package Brand\Standard\Controllers
 */
class LoginController extends Controller
{
    /**
     * 登录
     * @param LoginRequest $request
     * @param LoginService $loginService
     * @return array|void
     * @throws \Exception
     */
    public function login( LoginRequest $request , LoginService $loginService ){

        return $this->responseSuccess(
            $loginService->authLogin( $request->input('username') , $request->input('password') )
        );
    }

    /**
     * 退出
     * @param Request $request
     * @param LoginService $loginService
     * @return array
     */
    public function loginOut(Request $request ,LoginService $loginService){
        return $this->responseSuccess(
            $loginService->loginOut( $request->header('Authorization') )
        );
    }
}
