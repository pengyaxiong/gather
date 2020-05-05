<?php
Route::group(['prefix' => 'tool', 'namespace' => 'Tool', 'as' => 'tool.'], function () {

    Route::group(['prefix' => 'spider'], function () {
        Route::delete('destroy_checked', 'SpiderController@destroy_checked')->name('spider.destroy_checked');
        Route::patch('is_something', 'SpiderController@is_something')->name('spider.is_something');

        //回收站
        Route::get('trash', 'SpiderController@trash')->name('spider.trash');
        Route::get('{spider}/restore', 'SpiderController@restore')->name('spider.restore');
        Route::delete('{spider}/force_destroy', 'SpiderController@force_destroy')->name('spider.force_destroy');
        Route::delete('force_destroy_checked', 'SpiderController@force_destroy_checked')->name('spider.force_destroy_checked');
        Route::post('restore_checked', 'SpiderController@restore_checked')->name('spider.restore_checked');
    });
    Route::resource('spider', 'SpiderController');

    //公告
    Route::resource('notice', 'NoticeController');
    //帮助中心
    Route::resource('help', 'HelpController');
    //轮播图
    Route::group(['prefix' => 'slide'], function () {
        Route::patch('sort_order', 'SlideController@sort_order')->name('slide.sort_order');
        Route::patch('is_something', 'SlideController@is_something')->name('slide.is_something');
    });
    Route::resource('slide', 'SlideController');
    //关于我们
    Route::group(['prefix' => 'about'], function () {
        Route::get('/', 'AboutController@edit')->name('about.edit');
        Route::put('/', 'AboutController@update')->name('about.update');
    });
});