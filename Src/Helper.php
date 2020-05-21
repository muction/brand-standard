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
 * 
 */
if( !function_exists( 'requestId') ){
    function requestId( $default =""){
        return request('RequestId' , $default);
    }
}
