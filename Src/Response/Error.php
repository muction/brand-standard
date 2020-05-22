<?php namespace Brand\Standard\Response;
class Error
{

    //系统基础响应错误代码
    const REQUEST_SUCCESS_CODE = 0;  //请求成功
    const REQUEST_FAIL_CODE = 1; //请求失败
    const APP_ERROR = 500 ; //

    //forbiddent
    const REQUEST_FORBIDDENT_CODE = 403;
    const REQUEST_FORBIDDENT_MSG = '您无权限';

    //not found
    const REQUEST_NOT_FOUND_CODE = 404;
    const REQUEST_NOT_FOUND_MSG = '实体没有找到~';
    
}
