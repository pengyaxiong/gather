<?php
Route::group(['prefix' => 'customer', 'namespace' => 'Customer', 'as' => 'customer.'], function () {

    Route::post('login', 'LoginController@login')->name('login');

    Route::post('phone_login', 'RegisterController@phone_login')->name('phone_login');

    Route::post('change_password', 'RegisterController@change_password')->name('change_password');

    Route::get('logout', 'LoginController@logout')->name('logout');


    Route::middleware('auth:api')->any('update', 'CustomerController@update')->name('update');


    Route::post('register', 'RegisterController@register')->name("register");

    Route::middleware('auth:api')->post('reset', 'ResetPasswordController@reset')->name("reset");

    Route::post('sms', 'RegisterController@sms')->name('sms');

});