<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function getWxToken()
    {
        $appid= 'wx1946abd52243daa0';
        $appsecret = 'e944e4a177e2d7d353d4f392f10b5b75';
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        $data = file_get_contents($url);
        echo $data;
    }
}
