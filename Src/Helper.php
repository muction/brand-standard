<?php

/**
 * 标准系统配置文件获取
 * @param string $input 输入参数，格式按照config函数传入
 * @return mixed
 */
if(!file_exists('configStandard')){
    function configStandard(string $input ){
        return config('brandStandard.'. $input );
    }
}
