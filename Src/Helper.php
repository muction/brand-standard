<?php
use \Illuminate\Support\Facades\Log;

/**
 * 标准系统配置文件获取
 * @param string $input 输入参数，格式按照config函数传入
 * @return mixed
 */
if(!function_exists('configStandard')){
    function configStandard(string $input ){
        return config('brandStandard.'. $input );
    }
}

/**
 * 请求标识
 */
if( !function_exists( 'requestId') ){
    function requestId( $default =""){
        return request('RequestId' , $default);
    }
}

/**
 * 请求标识
 */
if( !function_exists( 'loginUserToken') ){
    function loginUserToken(){
        return request()->header('Authorization');
    }
}


/**
 * 生成MD5-token值
 */
if( !function_exists( "makeToken") ){
    function makeToken( string $input , $salt = ""){
        return strtoupper( md5( $input . $salt ) ) ;
    }
}
