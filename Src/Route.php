<?php

//标准版本路由
Route::group([ 'middleware'=>'brand.middleware' ,'prefix'=>'brand' ,'namespace'=>'Brand\Standard\Controllers' ],
    function(){
        Route::get('/ss' , 'IndexController@index')->name( 'brand.home.index' );

        Route::post('/auth/login' , 'AuthController@login')->name( 'brand.auth.login' );
    }
);
