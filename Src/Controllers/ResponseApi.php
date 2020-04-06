<?php


namespace Brand\Standard\Controllers;
use Illuminate\Support\MessageBag;

trait ResponseApi
{
    /**
     * 成功响应
     * @param array $data
     * @return array
     */
    public function responseSuccess( $data =[]  ){

        return $this->responseStructure( 200 ,0 , "操作成功" , $data );
    }

    /**
     * 失败响应
     * @param array $data
     * @param int $errorCode
     * @return array
     */
    public function responseError( $data = [] , $errorCode=1 ){
        return $this->responseStructure( 200 ,$errorCode , "操作失败" , $data );

    }

    /**
     * 响应校验器
     * @param MessageBag $error
     * @param int $errorCode
     * @return array
     */
    public function responseValidatorError(MessageBag $error , $errorCode=1){
        return $this->responseError( $error->toArray() , $errorCode );
    }

    /**
     * 响应API结构体
     * @param $statusCode
     * @param $errorCode
     * @param $msg
     * @param $body
     * @return array
     */
    private function responseStructure( $statusCode, $errorCode , $msg, $body ){
        return [
            'status'=>$statusCode ,
            'error'=> $errorCode,
            'msg' => $msg ,
            'body'=> $body
        ];
    }
}
