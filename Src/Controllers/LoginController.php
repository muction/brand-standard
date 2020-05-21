<?php
namespace Brand\Standard\Controllers;
use Brand\Standard\Requests\LoginRequest;
use Brand\Standard\Service\LoginService;
use Illuminate\Support\Facades\Log;

/**
 * 登录服务，返回Token
 * Class LoginController
 * @package Brand\Standard\Controllers
 */
class LoginController extends Controller
{
    /**
     * @param LoginRequest $request
     * @param LoginService $loginService
     * @return array|void
     * @throws \Exception
     */
    public function login( LoginRequest $request , LoginService $loginService ){
        
        return $loginService->authLogin( $request->input('username') , $request->input('password') );

    }
}
