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

Route::group(['middleware' => 'auth'], function () {
    /**
     * Users CONTROLLERS
     */
    Route::any('admin/users/getDataAjax', 'UsersController@getDataAjax');
    Route::get('admin/users', 'UsersController@index');
    Route::get('admin/users/create', 'UsersController@create');
    Route::post('admin/users', 'UsersController@store');
    Route::get('admin/users/{id}/edit', 'UsersController@edit');
    Route::put('admin/users/{id}', 'UsersController@update');
    Route::get('admin/users/{id}/del', 'UsersController@destroy');

    /**
     * Roles CONTROLLERS
     */
    Route::any('admin/roles/getDataAjax', 'RolesController@getDataAjax');
    Route::get('admin/roles', 'RolesController@index');
    Route::get('admin/roles/create', 'RolesController@create');
    Route::post('admin/roles', 'RolesController@store');
    Route::get('admin/roles/{id}/edit', 'RolesController@edit');
    Route::put('admin/roles/{id}', 'RolesController@update');
    Route::get('admin/roles/{id}/del', 'RolesController@destroy');

    /**
     * Permission CONTROLLERS
     */
    Route::any('admin/permission/getDataAjax', 'PermissionController@getDataAjax');
    Route::get('admin/permission', 'PermissionController@index');
    Route::post('admin/permission/store', 'PermissionController@store');

    /**
     * Category CONTROLLERS
     */
    Route::get('admin/category', 'CategoryController@index');
    Route::get('admin/category/getJsonData', 'CategoryController@getJsonData');
    Route::post('admin/category', 'CategoryController@store');
    Route::get('admin/category/create', 'CategoryController@create');

    Route::post('admin/category/update', 'CategoryController@update');
    Route::post('admin/category/delete', 'CategoryController@delete');
    Route::get('admin/category/test', 'CategoryController@test');

    /**
     * Style CONTROLLERS
     */
    Route::any('admin/style/getDataAjax', 'StyleController@getDataAjax');
    Route::get('admin/style', 'StyleController@index');
    Route::get('admin/style/create', 'StyleController@create');
    Route::post('admin/style', 'StyleController@store');
    Route::get('admin/style/{id}/edit', 'StyleController@edit');
    Route::put('admin/style/{id}', 'StyleController@update');
    Route::get('admin/style/{id}/del', 'StyleController@destroy');

    /**
     * Madein CONTROLLERS
     */
    Route::any('admin/madein/getDataAjax', 'MadeinController@getDataAjax');
    Route::get('admin/madein', 'MadeinController@index');
    Route::get('admin/madein/create', 'MadeinController@create');
    Route::post('admin/madein', 'MadeinController@store');
    Route::get('admin/madein/{id}/edit', 'MadeinController@edit');
    Route::put('admin/madein/{id}', 'MadeinController@update');
    Route::get('admin/madein/{id}/del', 'MadeinController@destroy');

    /**
     * Material CONTROLLERS
     */
    Route::any('admin/material/getDataAjax', 'MaterialController@getDataAjax');
    Route::get('admin/material', 'MaterialController@index');
    Route::get('admin/material/create', 'MaterialController@create');
    Route::post('admin/material', 'MaterialController@store');
    Route::get('admin/material/{id}/edit', 'MaterialController@edit');
    Route::put('admin/material/{id}', 'MaterialController@update');
    Route::get('admin/material/{id}/del', 'MaterialController@destroy');

    /**
     * Height CONTROLLERS
     */
    Route::any('admin/height/getDataAjax', 'HeightController@getDataAjax');
    Route::get('admin/height', 'HeightController@index');
    Route::get('admin/height/create', 'HeightController@create');
    Route::post('admin/height', 'HeightController@store');
    Route::get('admin/height/{id}/edit', 'HeightController@edit');
    Route::put('admin/height/{id}', 'HeightController@update');
    Route::get('admin/height/{id}/del', 'HeightController@destroy');

    /**
     * Product CONTROLLERS
     */
    Route::any('admin/product/getDataAjax', 'ProductController@getDataAjax');
    Route::get('admin/product', 'ProductController@index');
    Route::get('admin/product/create', 'ProductController@create');
    Route::post('admin/product', 'ProductController@store');
    Route::get('admin/product/{id}/edit', 'ProductController@edit');
    Route::post('admin/product/update', 'ProductController@update');
    Route::get('admin/product/{id}/del', 'ProductController@destroy');


    Route::get('admin/home', 'HomeController@index');
    Route::get('home', 'HomeController@index');
});
/**
 * Login
 */
Route::controllers([
    'auth'     => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('front-end', 'TestController@index');
//Route::get('auth/notification','NotificationController@index');
Route::get('user/active/{id}/{key}', 'UsersController@active');


/**
 * Front-End
 */

Route::get('/', 'FrontendController@index');
Route::get('cart', 'FrontendController@cart');
Route::get('cart/update/{id}', 'FrontendController@addcart');
Route::get('cart/del/{id}', 'FrontendController@destroy');
Route::get('cart/deleteall', 'FrontendController@deleteall');