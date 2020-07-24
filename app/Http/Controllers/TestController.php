<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class TestController extends Controller
{
    /**
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     * 加密
     */
    public function encrypt(Request $request)
    {
        echo "加密";
        $method = 'AES-256-CBC';
        $key = 'api1911';
        $iv = '1616161616161616';
        $option = OPENSSL_RAW_DATA;
        $url = 'http://api.1911.com/dec';
        $data = "真没想到啊。。。"; //要加密的数据
        $enc_data = openssl_encrypt($data,$method,$key,$option,$iv);
        echo "密文 :" . $enc_data; echo '</br>';
        $b64_str = base64_encode($enc_data);
        echo "base64 :" . $b64_str ;echo '</br>';


        $client = new Client();
        $response = $client->request('post',$url,[
            'form_params' => [
                'data' => $b64_str
            ]
        ]);
        echo $response->getBody(); //响应数据

//        $api = $url .'?data='.urlencode($b64_str);
//        $response = file_get_contents($api);
//        var_dump($response);
    }
    public function encrypt2(Request $request)
    {
        $data = "这是非对称加密的内容";

        //使用公钥加密
        $content = file_get_contents(storage_path("keys/api_pub.key"));
        $pub_key=openssl_get_publickey($content);
        openssl_public_encrypt($data,$enc_data,$pub_key);
        echo "加密后".$enc_data.'<br>';
        //post数据
        $post_data = [
            'data'=>$enc_data
        ];
        //将加密的文件发送
        $url = 'http://api.1911.com/dec2';
        //curl初始
        $ch = curl_init();
        //设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //发送请求
        $response = curl_exec($ch);
        echo $response;
        //提示错误
        $errno =curl_errno($ch);
        if($errno){
            $errmsg = curl_error($ch);
            var_dump($errmsg);
        }
        curl_close($ch);

    }
    public function dec3(Request $request)
    {
        $enc_data=$_POST['data'];
        $priv_key = openssl_get_privatekey(file_get_contents(storage_path('keys/priv.key')));
        openssl_private_decrypt($enc_data,$dec_data,$priv_key);
        echo "解密的数据：". $dec_data;
    }
    public function sign(Request $request)
    {
        $data = "验签验签";
        $key = "api1911";
        $sign_str = sha1($data . $key); //签名
        $url = 'http://api.1911.com/sign1?data='.$data.'&sign='.$sign_str;
        $response = file_get_contents($url);
        echo $response;

    }
}
