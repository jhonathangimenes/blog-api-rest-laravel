<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('auth/login', 'AuthController@authenticate');



Route::post('/user', 'UserController@store');

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::get('/blog', 'BlogDataController@index');
    Route::post('/blog', 'BlogDataController@store');
    Route::patch('/blog/{id}', 'BlogDataController@update');

    Route::get('/blog-addresses', 'BlogAddressesController@index');
    Route::post('/blog-addresse', 'BlogAddressesController@store');
    Route::patch('/blog-addresse/{id}', 'BlogAddressesController@update');
    Route::delete('/blog-addresse/{id}', 'BlogAddressesController@destroy');

    Route::get('/blog-phones', 'BlogPhoneController@index');
    Route::post('/blog-phone', 'BlogPhoneController@store');
    Route::patch('/blog-phone/{id}', 'BlogPhoneController@update');
    Route::delete('/blog-phone/{id}', 'BlogPhoneController@destroy');

    Route::get('/blog-social-networks', 'BlogSocialNetworkController@index');
    Route::post('/blog-social-network', 'BlogSocialNetworkController@store');
    Route::patch('/blog-social-network/{id}', 'BlogSocialNetworkController@update');
    Route::delete('/blog-social-network/{id}', 'BlogSocialNetworkController@destroy');

    Route::get('/users', 'UserController@index');
    Route::get('/user/{id}', 'UserController@show');
    Route::patch('/user/{id}', 'UserController@update');
    Route::delete('/user/{id}', 'UserController@destroy');

    Route::get('/posts', 'PostController@index');
    Route::post('/post', 'PostController@store')->middleware(['permissionPost']);
    Route::get('/post/{id}', 'PostController@show');
    Route::patch('/post/{id}', 'PostController@update')->middleware(['permissionPost']);
    Route::delete('/post/{id}', 'PostController@destroy')->middleware(['permissionPost']);

    Route::post('/permissionUser', 'PermissionUserController@store')->middleware(['permissionUser']);
    Route::patch('/permissionUser/{id}', 'PermissionUserController@update')->middleware(['permissionUser']);
    Route::delete('/permissionUser/{id}', 'PermissionUserController@destroy')->middleware(['permissionUser']);
});