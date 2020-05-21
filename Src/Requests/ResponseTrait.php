<?php namespace Brand\Standard\Requests;

use Brand\Standard\Exceptions\ExceptionResponseCode;
use Illuminate\Support\MessageBag;

Trait ResponseTrait
{
    /**
     * 成功响应
     * @param array $data
     * @param string $msg
     * @param array $extra
     * @return array
     */
    public function responseSuccess( $data =[] , $msg= '操作成功' , $extra =[] ){

        return $this->responseStructure( 200 ,ExceptionResponseCode::REQUEST_SUCCESS_CODE , $msg , $data ,$extra );
    }

    /**
     * 失败响应
     * @param array $data
     * @param string $message
     * @param int $errorCode
     * @param array $extra
     * @return array
     */
    public function responseError( $data = [] , $message = '操作失败' , $errorCode= ExceptionResponseCode::REQUEST_FAIL_CODE ,$extra =[] ){
        return $this->responseStructure( 200 ,$errorCode , $message , $data , $extra );

    }

    /**
     * 响应校验器
     * @param MessageBag $error
     * @param int $errorCode
     * @return array
     */
    public function responseValidatorError(MessageBag $error , $errorCode= ExceptionResponseCode::REQUEST_FAIL_CODE ){
        return $this->responseError( $error->toArray() , $errorCode );
    }

    /**
     * 响应API结构体
     * @param $statusCode
     * @param $errorCode
     * @param $msg
     * @param $data
     * @param array $extra
     * @return array
     */
    private function responseStructure( $statusCode, $errorCode , $msg, $data ,$extra=[] ){
        return [
            'status'=>$statusCode ,
            'error'=> $errorCode,
            'msg' => $msg ,
            'data'=> $data ,
            'extra'=> $extra,
            'request_id' => requestId()
        ];
    }
}
