<?php
Route::group(['prefix' => 'system', 'namespace' => 'System', 'as' => 'system.'], function () {


    Route::get('config', 'ConfigController@index')->name('index');

});