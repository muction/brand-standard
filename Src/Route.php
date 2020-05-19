<?php

//标准版本路由
Route::group([ 'middleware'=>'brand.middleware' ,'prefix'=>'api/standard/' ,'namespace'=>'Brand\Standard\Controllers' ],
    function(){
        Route::post( 'login' , 'LoginController@login')->name( 'standard.login' );

        Route::get('administrators'  , 'AdminController@administrators')-> name( 'standard.admin.administrators');
        Route::post('administrators' , 'AdminController@administratorsStorage')-> name( 'standard.admin.administrators.create');
        Route::get('branchs' , 'AdminController@branch')-> name( 'standard.admin.branch');
        Route::get('roles' , 'AdminController@role')-> name( 'standard.admin.role');
        Route::get('permissions' , 'AdminController@permission')-> name( 'standard.admin.permission');
    }
);
