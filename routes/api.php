<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/customer', function (Request $request) {
    return success_data('成功', $request->user());
});

Route::group(['domain' => env('ADMIN_DOMAIN'), 'namespace' => 'Api', 'as' => 'api.'], function () {

    //用户统计
    Route::get('statistics_customer', 'VisualizationController@statistics_customer');
    //流量统计
    Route::get('statistics_supermarket', 'VisualizationController@statistics_supermarket');
    //流量统计
    Route::get('statistics_product', 'VisualizationController@statistics_product');
    //产品点击数统计
    Route::get('supermarket_pv/{user_id}/{start_date}/{end_date}', 'VisualizationController@supermarket_pv');

    Route::get('product_pv/{user_id}/{start_date}/{end_date}', 'VisualizationController@product_pv');

    //会员管理
    require 'api/customer.php';
    //系统管理
    require 'api/system.php';
    //工具管理
    require 'api/tool.php';

});