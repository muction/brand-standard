<?php namespace Brand\Standard\Response;
class Error
{
    /** ---------------------------------------- 系统标准定义错误 ---------------------------------------------------- **/

    //有效状态
    const STATUS_VALID = 1;

    //无效状态
    const STATUS_INVALID =0;

    //系统基础响应错误代码
    const REQUEST_SUCCESS_CODE = 0;  //请求成功
    const REQUEST_FAIL_CODE = 1; //请求失败
    const APP_ERROR = 500; //

    //forbiddent
    const REQUEST_FORBIDDENT_CODE = 403;
    const REQUEST_FORBIDDENT_MSG = '您无权限';

    //not found
    const REQUEST_NOT_FOUND_CODE = 404;
    const REQUEST_NOT_FOUND_MSG = '实体没有找到~';

    //Unauthorized
    const REQUEST_UNAUTHORIZED_CODE = 401;
    const REQUEST_UNAUTHORIZED_MSG = "未登录系统";

    //Bad Request
    const REQUEST_BAD_REQUEST_CODE = 400;
    const REQUEST_BAD_REQUEST_MSG = '请求中有语法错误';


    /** ----------------------------------------- 系统自定义错误 ----------------------------------------------------- **/

    const APP_ULTRA_VIRES_MSG = '被拒绝操作，出现这个问题，大部分是由于系统限制了当前逻辑形态，如有疑问，请联系管理员~';
    const APP_ULTRA_VIRES_CODE = 10000;

    const APP_ORIGIN_PASSWORD_ERROR_MSG = '原始密码错误';
    const APP_ORIGIN_PASSWORD_ERROR_CODE = 10001;

    const APP_VALIDATOR_FAIL_MSG = '验证失败，请检查用户名密码';
    const APP_VALIDATOR_FAIL_CODE = 10002;


}
