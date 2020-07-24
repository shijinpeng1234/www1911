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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/encrypt','TestController@encrypt'); //对称加密
Route::get('/encrypt2','TestController@encrypt2');//非对称加密
Route::post('dec3','TestController@dec3');//解密

Route::get('sign','TestController@sign');//验签

Route::get('sign2','TestController@sign2');
