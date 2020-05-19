<?php
namespace Brand\Standard\Controllers;
use Brand\Standard\Service\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * 登录服务，返回Token
 * Class LoginController
 * @package Brand\Standard\Controllers
 */
class LoginController extends Controller
{
    /**
     * @param Request $request
     * @param LoginService $loginService
     * @return array|void
     * @throws \Exception
     */
    public function login( Request $request , LoginService $loginService ){

        $validator= Validator::make( $request->all(), [
            'username'=>'required',
            'password'=>'required'
        ] , [
                'username.required'=>'登录名必填',
                'password.required'=>'密码必填'
            ]
        );
        if($validator->fails()){
            return $this->responseValidatorError( $validator->errors() );
        }

        return $loginService->authLogin( $request->input('username') , $request->input('password') );

    }
}
