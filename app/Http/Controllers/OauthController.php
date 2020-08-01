<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OauthController extends Controller
{
    public function git(Request $request)
    {
        $code = $request->get('client_id');
        print_r($code);
    }
}
