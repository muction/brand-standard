<?php
namespace Brand\Standard\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Stars\Permission\Entity\RbacUser;
use Validator;

class AdminController extends BrandStandardController
{
    /**
     * 创建用户
     * @param Request $request
     * @param RbacUser $starsUser
     * @return mixed
     */
    public function storageUser(Request $request, RbacUser $starsUser){

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
        return $starsUser->createUser( $username, Hash::make( $password) , 1 );
    }
}
