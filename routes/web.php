<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//前台
Route::group(['middleware' => ['uv'],'namespace' => 'Customer', 'domain' => env('HOME_DOMAIN')], function () {

    //前台首页
    Route::get('/', 'HomeController@index');

    //会员管理
    Route::group(['prefix' => 'customer', 'as' => 'customer.'], function () {

        Route::get('login', 'LoginController@showLoginForm')->name('login');
        Route::post('login', 'LoginController@login')->name('do_login');;
        Route::get('logout', 'LoginController@logout')->name('logout');

        Route::post('register', 'RegisterController@register')->name("do_register");
        Route::get('register', 'RegisterController@index')->name("register");
    });
});

//后台
Route::group(['domain' => env('ADMIN_DOMAIN')], function () {
    //登录注册
    Auth::routes();

    Route::group(['middleware' => ['auth', 'sidebar', 'role'], 'namespace' => 'Admin'], function () {

        //后台首页
        Route::group(['prefix' => 'admin'], function () {
            Route::get('/', 'HomeController@index')->name('admin');
            Route::put('/{id}', 'HomeController@update')->name('admin.update');
            Route::get('/link', 'HomeController@link')->name('admin.link');
        });

        //工具管理
        require 'admin/tool.php';
        //系统管理
        require 'admin/system.php';
        //内容管理
        require 'admin/cms.php';
        //消息管理
        // require 'admin/information.php';
    });
});

