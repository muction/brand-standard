<?php

//标准版本路由
Route::group([ 'middleware'=>'brand.middleware' ,'prefix'=>'brand' ,'namespace'=>'Brand\Standard\Controllers' ],
    function(){
        Route::post('/auth/login' , 'AuthController@login')->name( 'brand.auth.login' );
        Route::post('/user' , 'AdminController@storageUser')->name( 'brand.user.add' );
    }
);
