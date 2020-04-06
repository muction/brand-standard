<?php
namespace Brand\Standard\Controllers;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Validator;
class AuthController extends BaseController
{
    use ResponseApi;

    public function login(Request $request){

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

        
        return 3;
    }


}
