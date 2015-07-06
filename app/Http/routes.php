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

Route::get('/', function () {
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
