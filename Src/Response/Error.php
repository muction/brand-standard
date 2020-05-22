<?php namespace Brand\Standard\Response;
class Error
{
    /** ---------------------------------------- 系统标准定义错误 ---------------------------------------------------- **/

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

    //Unauthorized
    const REQUEST_UNAUTHORIZED_CODE = 401;
    const REQUEST_UNAUTHORIZED_MSG = "您未登录";

    //Bad Request
    const REQUEST_BAD_REQUEST_CODE = 400;
    const REQUEST_BAD_REQUEST_MSG = '请求中有语法错误';


    /** ----------------------------------------- 系统自定义错误 ----------------------------------------------------- **/




}
