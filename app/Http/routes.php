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
     * Order CONTROLLERS
     */
    Route::any('admin/order/getDataAjax', 'OrderController@getDataAjax');
    Route::get('admin/order', 'OrderController@index');
    Route::get('admin/order/{id}/edit', 'OrderController@edit');
    Route::post('admin/order/update', 'OrderController@update');
    Route::post('admin/order/addproduct', 'OrderController@addproduct');
    Route::get('admin/order/{id}/deleteItemInOrder', 'OrderController@deleteItemInOrder');

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
    Route::get('admin/category/getDataForJstree', 'CategoryController@getDataForJstree');
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

    /**
     * Size CONTROLLERS
     */
    Route::any('admin/size/getDataAjax', 'SizeController@getDataAjax');
    Route::get('admin/size', 'SizeController@index');
    Route::get('admin/size/create', 'SizeController@create');
    Route::post('admin/size', 'SizeController@store');
    Route::get('admin/size/{id}/edit', 'SizeController@edit');
    Route::post('admin/size/update', 'SizeController@update');
    Route::get('admin/size/{id}/del', 'SizeController@destroy');

    /**
     * Color CONTROLLERS
     */
    Route::any('admin/color/getDataAjax', 'ColorController@getDataAjax');
    Route::get('admin/color', 'ColorController@index');
    Route::get('admin/color/create', 'ColorController@create');
    Route::post('admin/color', 'ColorController@store');
    Route::get('admin/color/{id}/edit', 'ColorController@edit');
    Route::post('admin/color/update', 'ColorController@update');
    Route::get('admin/color/{id}/del', 'ColorController@destroy');

    /**
     * Invoice Import CONTROLLERS
     */
    Route::any('admin/invoiceimport/getDataAjax', 'InvoiceImportController@getDataAjax');
    Route::get('admin/invoiceimport', 'InvoiceImportController@index');
    Route::get('admin/invoiceimport/import', 'InvoiceImportController@import');
    Route::post('admin/invoiceimport', 'InvoiceImportController@store');
    Route::get('admin/invoiceimport/view', 'InvoiceImportController@view');
    Route::post('admin/invoiceimport/update', 'InvoiceImportController@update');
    Route::get('admin/invoiceimport/delete/{id}', 'InvoiceImportController@delete');
    Route::get('admin/invoiceimport/{id}/edit', 'InvoiceImportController@viewDetail');
    Route::get('admin/invoiceimport/checkout', 'InvoiceImportController@checkout');
    Route::post('admin/invoiceimport/checkout', 'InvoiceImportController@checkoutpost');
    Route::get('admin/invoiceimport/test', 'InvoiceImportController@test');
    Route::get('admin/invoiceimport/test2', 'InvoiceImportController@test2');


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

//alias for routes
/*
 get( '/account-register' , [
    'as' => 'auth.register' ,
    'uses' => 'Auth\AuthController@getRegister'
] );
*/

Route::get('front-end', 'TestController@index');
//Route::get('auth/notification','NotificationController@index');
Route::get('user/active/{id}/{key}', 'UsersController@active');


/**
 * Front-End
 */

Route::get('/', 'FrontendController@index');
Route::get('order', 'FrontendController@order');

Route::get('order/update/{id}', 'FrontendController@addorder');
Route::get('order/del/{id}', 'FrontendController@destroy');
Route::get('order/deleteall', 'FrontendController@deleteall');

//show info product
Route::get('product/{id}', 'FrontendController@product');
Route::post('product/fastview', 'FrontendController@getProductForFastView');
//show product by category
Route::get('category/{id}', 'FrontendController@showProductByCategory');

//contact in frontend
Route::get('contact', 'FrontendController@contact');

/**
 * Order Product
 */
Route::get('product/{id}', 'FrontendController@product');
Route::post('cart/addproduct', 'FrontendController@addorder');
Route::get('cart/view', 'FrontendController@vieworder');
Route::get('cart/delete/{id}', 'FrontendController@deletecartitem');
Route::post('cart/update', 'FrontendController@updateorder');
Route::get('cart/checkout', 'FrontendController@checkout');
Route::post('cart/checkout', 'FrontendController@submitcheckout');

Route::get('test', 'FrontendController@test');
Route::get('test2', 'FrontendController@test2');

