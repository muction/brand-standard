<?php
namespace Brand\Standard\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
use Stars\Permission\Entity\StarsUser;

class AuthController extends BaseController
{
    use ResponseApi;

    public function login(Request $request , StarsUser $starsUser ){

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

        return $info;
    }


}
