<?php
namespace Brand\Standard\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Stars\Permission\Entity\RbacUser;

use Illuminate\Support\Facades\Redis;

class AuthController extends BaseController
{
    use ResponseApi;

    public function login(Request $request , RbacUser $starsUser ){

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

        $username = $request->input('username') ;
        $password = $request->input('password');
        $info = $starsUser->detail(['username'=>$username ,'status'=>1]);
        if(!$info|| !Hash::check( $password , $info->password ) ){
            return $this->responseError();
        }

        //记录token
        $token= md5( $username.$info->id ) ;
        $redis= Redis::set($token , $username ,'EX',3600 );
        if(!$redis){
            throw new \Exception("存储登录信息时发生错误，请联系系统管理员");
        }

        return [
            'username'=> $info->username,
            'token'=> $token,
            'roles'=> $info->roles ,
            'permissions'=>[]
        ];
    }


}
