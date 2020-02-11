<?php

Route::group(['middleware' => ['uv'], 'prefix' => 'tool', 'namespace' => 'Tool', 'as' => 'tool.'], function () {

    Route::get('spider', 'SpiderController@index')->name('spider');
    Route::get('spider/{id}', 'SpiderController@show')->name('spider.show');

});