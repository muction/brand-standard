<?php

//标准版本路由
Route::group([ 'middleware'=>'brand.middleware' ,'prefix'=>'api/standard/' ,'namespace'=>'Brand\Standard\Controllers' ],
    function(){
        Route::post( 'login' , 'LoginController@login')->name( 'standard.login' );


        Route::get('administrators'  , 'AdminController@administrators')-> name( 'standard.admin.administrators');
        Route::post('administrators' , 'AdminController@administratorsStorage')-> name( 'standard.admin.administrators.storage');
        Route::post('administrators/{id}' , 'AdminController@administratorsModify')-> name( 'standard.admin.administrators.modify');
        Route::post('rm/administrators/{id}' , 'AdminController@administratorsRemove')-> name( 'standard.admin.administrators.remove');


        Route::get('branchs' , 'AdminController@branch')-> name( 'standard.admin.branch');
        Route::post('branchs' , 'AdminController@branchStorage')-> name( 'standard.admin.branch.storage');
        Route::post('branchs/{id}' , 'AdminController@branchModify')-> name( 'standard.admin.branch.modify');
        Route::post('rm/branchs/{id}' , 'AdminController@branchRemove')-> name( 'standard.admin.branch.remove');


        Route::get('roles' , 'AdminController@role')-> name( 'standard.admin.role');
        Route::post('roles' , 'AdminController@roleStorage')-> name( 'standard.admin.role.storage');
        Route::post('roles/{id}' , 'AdminController@roleModify')-> name( 'standard.admin.role.modify');
        Route::post('roles/bind/permissions/{id}' , 'AdminController@roleBindPermission')-> name( 'standard.admin.role.bind.permissions');
        Route::post('rm/roles/{id}' , 'AdminController@roleRemove')-> name( 'standard.admin.role.remove');


        Route::get('permissions' , 'AdminController@permission')-> name( 'standard.admin.permission');
    }
);
