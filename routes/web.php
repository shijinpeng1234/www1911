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
Route::get('/phpinfo','TestController@phpinfo');

Route::get('/encrypt','TestController@encrypt'); //对称加密
Route::get('/encrypt2','TestController@encrypt2');//非对称加密
Route::post('dec3','TestController@dec3');//解密

Route::get('sign','TestController@sign');//验签

Route::get('sign2','TestController@sign2');//验签2

Route::get('sign3','TestController@sign3');//验签加密

Route::get('/shop/login','Shop\ShopController@login');//登录
Route::get('/shop/register','Shop\ShopController@register');//注册




Route::get('test/pay','TestController@testpay');
Route::get('pay','TestController@pay');


Route::get('/git','OauthController@git');












