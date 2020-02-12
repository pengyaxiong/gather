<?php
Route::group(['prefix' => 'system', 'namespace' => 'System', 'as' => 'system.'], function () {

    // 清除缓存
    Route::get('cache', 'CacheController@index')->name('cache.index');
    Route::delete('cache', 'CacheController@destroy')->name('cache.destroy');

    // 上传设置
    Route::group(['prefix' => 'photo'], function () {
        Route::get('photo', 'PhotoController@index')->name('photo.index');
        Route::get('/contents/{name}', 'PhotoController@get_contents')->name('photo.get_contents');
        Route::post('/upload_public', 'PhotoController@upload_public')->name('photo.upload_public');
        //自定义传入变量
        Route::delete('/destroy_file/{name}', 'PhotoController@destroy_file')->name('photo.destroy_file');
        Route::post('/update_file', 'PhotoController@update_file')->name('photo.update_file');

        Route::post('upload_icon', 'PhotoController@upload_icon')->name('photo.upload_icon');
        Route::post('upload', 'PhotoController@upload')->name('photo.upload');
        Route::post('upload_img', 'PhotoController@upload_img')->name('photo.upload_img');
        Route::post('upload_background_img', 'PhotoController@upload_background_img')->name('photo.upload_background_img');
    });

    // 系统设置
    Route::group(['prefix' => 'config'], function () {
        Route::get('/', 'ConfigController@edit')->name('config.edit');
        Route::put('/', 'ConfigController@update')->name('config.update');
    });

    // 用户权限
    Route::patch('permission/sort_order', 'PermissionController@sort_order')->name('permission.sort_order');
    Route::resource('permission', 'PermissionController');
    Route::patch('user/is_something', 'UserController@is_something')->name('user.is_something');
    Route::post('user/mail', 'UserController@mail')->name('user.mail');
    Route::resource('user', 'UserController');
    Route::resource('role', 'RoleController');

});