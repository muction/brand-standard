<?php

//标准版本路由
Route::group([ 'middleware'=>'brand.middleware' ,'prefix'=>'brand' ,'namespace'=>'Brand\Standard\Controllers' ],
    function(){
        Route::get('/' , 'IndexController@index')->name('brand.index');
    }
);
