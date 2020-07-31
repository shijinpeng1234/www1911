<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;

class TestController extends Controller
{
    public function phpinfo()
    {
        phpinfo();
    }
    /**
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     * 对称加密
     */
    public function encrypt(Request $request)
    {
        $method = 'AES-256-CBC';
        $key = 'api1911';
        $iv = '1616161616161616';
        $option = OPENSSL_RAW_DATA;
        $url = 'http://api.1911.com/dec';
        $data = "真没想到啊。。。"; //要加密的数据
        $enc_data = openssl_encrypt($data,$method,$key,$option,$iv);
//        echo "密文 :" . $enc_data; echo '</br>';
        $b64_str = base64_encode($enc_data);
//        echo "base64 :" . $b64_str ;echo '</br>';


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

    /**
     * @param Request $request
     * 非对称加密
     */
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

    /**
     * @param Request $request
     * 解密返回的数据
     */
    public function dec3(Request $request)
    {
        $enc_data=$_POST['data'];
        $priv_key = openssl_get_privatekey(file_get_contents(storage_path('keys/priv.key')));
        openssl_private_decrypt($enc_data,$dec_data,$priv_key);
        echo "解密的数据：". $dec_data;
    }

    /**
     * @param Request $request
     * 验签
     */
    public function sign(Request $request)
    {
        $data = "验签验签";
        $key = "api1911";
        $sign_str = sha1($data . $key); //签名
        $url = 'http://api.1911.com/sign1?data='.$data.'&sign='.$sign_str;
        $response = file_get_contents($url);
        echo $response;

    }

    /**
     *验签
     */
    public function sign2()
    {
        $data = "验签2";
        $content = file_get_contents(storage_path("keys/priv.key"));
        $prikey = openssl_get_privatekey($content);
//        var_dump($prikey);
        openssl_sign($data,$sign_str,$prikey,OPENSSL_ALGO_SHA1);
        echo $sign_str;echo '<br>';
        //post数据
        $post_data = [
            'data'=>$data,
            'sign'=>$sign_str
        ];
        //将加密的文件发送
        $url = 'http://api.1911.com/sign2';
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
        curl_close($ch);

    }

    /**
     * 验签加密
     */
    public function sign3()
    {
        $data = "一些数据";
        $data2 = "一堆数据";
        $contetn = file_get_contents(storage_path("keys/priv.key"));
        $privkey = openssl_get_privatekey($contetn);
        openssl_sign($data,$sign_str,$privkey,OPENSSL_ALGO_SHA1);

        $method = 'AES-256-CBC';
        $key = 'api1911';
        $iv = '1616161616161616';
        $option = OPENSSL_RAW_DATA;
        $url = 'http://api.1911.com/sign3';

        $enc_data = openssl_encrypt($data2,$method,$key,$option,$iv);

        $b64_str = base64_encode($enc_data);
        //post 数据
        $post_data = [
            'data'=>$data,
            'sign'=>$sign_str,
            'arr' =>$b64_str
        ];
        //发送加密文件
        $url = 'http://api.1911.com/sign3';
        $ch = curl_init();
        //设置参数
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        //发送请求
        $response = curl_exec($ch);
        echo $response;
        curl_close($ch);





//        $client = new Client();
//        $response = $client->request('post',$url,[
//            'form_params' => [
//                'data' => $b64_str
//            ]
//        ]);
//        echo $response->getBody(); //响应数据
    }

    public function testpay()
    {
        return view('test.goods');
    }
    public function pay(Request $request)
    {
        $oid = $request->get('oid');
        echo '订单ID：'.$oid;
        //根据订单ID查询到订单信息  订单号 订单金额

        //调用支付宝接口
        // 1 请求参数
        $param2 = [
            'out_trade_no'      => '',
            'out_trade_no'      => time().mt_rand(11111,99999),
            'product_code'      => 'FAST_INSTANT_TRADE_PAY',
            'total_amount'      => 99.99,
            'subject'           => '1911-测试订单-'.Str::random(16),
        ];
        // 2 公共参数
        $param1 = [
            'app_id'        => '2016101800713197',
            'method'        => 'alipay.trade.page.pay',
            'return_url'    => 'http://1911www.comcto.com/alipay/return',   //同步通知地址
            'charset'       => 'utf-8',
            'sign_type'     => 'RSA2',
            'timestamp'     => date('Y-m-d H:i:s'),
            'version'       => '1.0',
            'notify_url'    => 'http://1911sjp.comcto.com/alipay/notify',   // 异步通知
            'biz_content'   => json_encode($param2),
        ];
        //echo '<pre>';print_r($param1);echo '</pre>';
        // 计算签名
        ksort($param1);
        //echo '<pre>';print_r($param1);echo '</pre>';

        $str = "";
        foreach($param1 as $k=>$v)
        {
            $str .= $k . '=' . $v . '&';
        }

        $str = rtrim($str,'&');     // 拼接待签名的字符串

        $sign = $this->sign9($str);
        echo $sign;echo '<hr>';
        $url = 'https://openapi.alipaydev.com/gateway.do?'.$str.'&sign='.urlencode($sign);
        return redirect($url);
        //echo $url;
    }
    protected function sign9($data)
    {
        $priKey = file_get_contents(storage_path('keys/ali_priv.key'));
        $res = openssl_get_privatekey($priKey);
        var_dump($res);echo '<hr>';

        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');

        openssl_sign($data, $sign, $res, OPENSSL_ALGO_SHA256);
        openssl_free_key($res);
        $sign = base64_encode($sign);
        return $sign;
    }
}
