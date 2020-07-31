<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * 注册
     */
    public function register()
    {
        return view('shop.register');
    }
    /**
     * 登录
     */
    public function login()
    {
        return view('shop.login');
    }
}
