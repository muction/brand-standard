<?php

//标准版本路由

Route::group([ 'middleware'=>'brand.middleware' ,'prefix'=> configStandard('route_prefix') ,'namespace'=>'Brand\Standard\Controllers' ],

    function(){

        $perfix = 'brand.standard';

        Route::post( 'login' , 'LoginController@login')->name(  $perfix .'.login' );
        Route::post( 'login-out' , 'LoginController@loginOut')->name( $perfix .'.login.out' );

        Route::post( 'debug/test' , 'TestController@index')->name( $perfix .'.debug.test' );
        Route::get('debug/permissions' , 'TestController@debugPermission')-> name( $perfix .'.debug.permisssions');


        Route::get('administrators'  , 'AdminController@administrators')-> name( $perfix .'.administrators');
        Route::post('administrators' , 'AdminController@administratorsStorage')-> name( $perfix .'.administrators.storage');
        Route::post('administrators/{id}' , 'AdminController@administratorsModify')-> name( $perfix .'.administrators.modify');
        Route::post('rm/administrators/{id}' , 'AdminController@administratorsRemove')-> name( $perfix .'.administrators.remove');


        Route::get('branchs' , 'AdminController@branch')-> name( $perfix .'.branchs');
        Route::post('branchs' , 'AdminController@branchStorage')-> name( $perfix .'.branch.storage');
        Route::post('branchs/{id}' , 'AdminController@branchModify')-> name( $perfix .'.branch.modify');
        Route::post('rm/branchs/{id}' , 'AdminController@branchRemove')-> name( $perfix .'.branch.remove');


        Route::get('roles' , 'AdminController@role')-> name( $perfix .'.roles');
        Route::post('roles' , 'AdminController@roleStorage')-> name( $perfix .'.role.storage');
        Route::post('roles/{id}' , 'AdminController@roleModify')-> name( $perfix .'.role.modify');
        Route::post('roles/bind/permissions/{id}' , 'AdminController@roleBindPermission')-> name( $perfix .'.role.bind.permissions');
        Route::post('rm/roles/{id}' , 'AdminController@roleRemove')-> name( $perfix .'.role.remove');


        Route::get('permissions' , 'AdminController@permission')-> name( $perfix .'.permissions');
        Route::post('permissions' , 'AdminController@permissionStorage')-> name( $perfix .'.permission.storage');
        Route::post('permissions/{id}' , 'AdminController@permissionModify')-> name( $perfix .'.permission.modify');
        Route::post('rm/permissions/{id}' , 'AdminController@permissionRemove')-> name( $perfix .'.permission.remove');


    }
);
