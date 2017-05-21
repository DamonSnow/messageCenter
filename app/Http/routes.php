<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

//


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::any('/', 'LoginController@login');
    Route::any('logout','LoginController@logout');
    Route::any('login', 'LoginController@login');
});


Route::group(['middleware' => ['web','haslogin']],function(){

    //ActionController
    Route::any('action_index','ActionController@index');
    Route::any('action_insert','ActionController@insert');
    Route::any('action_update/{serial}','ActionController@update');
    Route::any('action_delete/{serial}','ActionController@delete');
//    Route::any('action_update_info','ActionController@update_info');


    //UserController
    Route::any('user_index', 'UserController@index');
    Route::any('user_update/{serial}','UserController@update');
//    Route::any('user_update_group','UserController@update_user_group');
    Route::any('user_group/{serial}','UserController@user_group');
    Route::any('user_add_group','UserController@user_add_group');

    //GroupController
    Route::any('group_index','GroupController@index');
    Route::any('group_insert','GroupController@insert');
    Route::any('group_update/{serial}','GroupController@update');
    Route::any('group_delete/{serial}','GroupController@delete');
    Route::any('group_update_info','GroupController@group_update_info');
//    Route::any('user_update/{serial}','UserController@update');
});
