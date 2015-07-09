<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/index', function () {
    return view('welcome');
});

Route::group(['middleware'=>'auth'],function(){
    /**
     * Users CONTROLLERS
     */
    Route::any('admin/users/getDataAjax','UsersController@getDataAjax');
    Route::get('admin/users','UsersController@index');
    Route::get('admin/users/create','UsersController@create');
    Route::post('admin/users','UsersController@store');
    Route::get('admin/users/{id}/edit','UsersController@edit');
    Route::put('admin/users/{id}','UsersController@update');
    Route::get('admin/users/{id}/del','UsersController@destroy');

    /**
     * Roles CONTROLLERS
     */
    Route::any('admin/roles/getDataAjax','RolesController@getDataAjax');
    Route::get('admin/roles','RolesController@index');
    Route::get('admin/roles/create','RolesController@create');
    Route::post('admin/roles','RolesController@store');
    Route::get('admin/roles/{id}/edit','RolesController@edit');
    Route::put('admin/roles/{id}','RolesController@update');
    Route::get('admin/roles/{id}/del','RolesController@destroy');

    /**
     * Permission CONTROLLERS
     */
    Route::any('admin/permission/getDataAjax','PermissionController@getDataAjax');
    Route::get('admin/permission','PermissionController@index');
    Route::post('admin/permission/store','PermissionController@store');

    /**
     * Category CONTROLLERS
     */
    Route::get('admin/category','CategoryController@index');
    Route::get('admin/category/getJsonData','CategoryController@getJsonData');
    Route::post('admin/category','CategoryController@store');
    Route::get('admin/category/create','CategoryController@create');

    Route::post('admin/category/update','CategoryController@update');
    Route::post('admin/category/delete','CategoryController@delete');
    Route::get('admin/category/test','CategoryController@test');

    /**
     * Style CONTROLLERS
     */
    Route::any('admin/style/getDataAjax','StyleController@getDataAjax');
    Route::get('admin/style','StyleController@index');
    Route::get('admin/style/create','StyleController@create');
    Route::post('admin/style','StyleController@store');
    Route::get('admin/style/{id}/edit','StyleController@edit');
    Route::put('admin/style/{id}','StyleController@update');
    Route::get('admin/style/{id}/del','StyleController@destroy');

    /**
     * Madein CONTROLLERS
     */
    Route::any('admin/madein/getDataAjax','MadeinController@getDataAjax');
    Route::get('admin/madein','MadeinController@index');
    Route::get('admin/madein/create','MadeinController@create');
    Route::post('admin/madein','MadeinController@store');
    Route::get('admin/madein/{id}/edit','MadeinController@edit');
    Route::put('admin/madein/{id}','MadeinController@update');
    Route::get('admin/madein/{id}/del','MadeinController@destroy');


    Route::get('admin/home','HomeController@index');
    Route::get('home','HomeController@index');
});
/**
 * Login
 */
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('front-end','TestController@index');
//Route::get('auth/notification','NotificationController@index');
Route::get('user/active/{id}/{key}','UsersController@active');



/**
 * Front-End
 */

Route::get('/','FrontendController@index');