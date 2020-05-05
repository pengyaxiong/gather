<?php
Route::group(['prefix' => 'service', 'namespace' => 'Service', 'as' => 'service.'], function () {

    //帮助中心
    Route::group(['prefix' => 'helper'], function () {
        Route::get('/', 'HelperController@edit')->name('helper.edit');
        Route::put('/', 'HelperController@update')->name('helper.update');
    });
    //联系客服
    Route::group(['prefix' => 'content'], function () {
        Route::get('/', 'ContentController@edit')->name('content.edit');
        Route::put('/', 'ContentController@update')->name('content.update');
    });
    //各类问题
    Route::resource('problem', 'ProblemController');
    //分享素材
    Route::resource('share', 'ShareController');
});