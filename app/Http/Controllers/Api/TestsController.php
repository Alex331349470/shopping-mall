<?php

namespace App\Http\Controllers\Api;

use Finecho\Logistics\Logistics;
use GuzzleHttp\Client;
use Illuminate\Http\Request;


class TestsController extends Controller
{
    public function show(Request $request)
    {

        $logisticResult=$this->getOrderTracesByJson($request->company, $request->code);

        return $logisticResult;

    }

    /**
     * Json方式 查询订单物流轨迹
     */
    protected function getOrderTracesByJson($company, $code){
        $requestData= "{'OrderCode':'','ShipperCode':'$company','LogisticCode':'$code'}";

        $datas = array(
            'EBusinessID' => env('LOGISTICS_CUSTOMER'),
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData) ,
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->encrypt($requestData, env('LOGISTICS_APP_CODE'));
        $result=$this->sendPost(env('LOGISTICS_URL'), $datas);

        //根据公司业务处理返回的信息......

        return $result;
    }

    /**
     *  post提交数据
     * @param  string $url 请求Url
     * @param  array $datas 提交的数据
     * @return url响应返回的html
     */
    protected function sendPost($url, $datas) {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if(empty($url_info['port']))
        {
            $url_info['port']=80;
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader.= "Host:" . $url_info['host'] . "\r\n";
        $httpheader.= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader.= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader.= "Connection:close\r\n\r\n";
        $httpheader.= $post_data;
        $fd = fsockopen($url_info['host'], $url_info['port']);
        fwrite($fd, $httpheader);
        $gets = "";
        $headerFlag = true;
        while (!feof($fd)) {
            if (($header = @fgets($fd)) && ($header == "\r\n" || $header == "\n")) {
                break;
            }
        }
        while (!feof($fd)) {
            $gets.= fread($fd, 128);
        }
        fclose($fd);

        return $gets;
    }

    /**
     * 电商Sign签名生成
     * @param data 内容
     * @param appkey Appkey
     * @return DataSign签名
     */
    protected function encrypt($data, $appkey) {
        return urlencode(base64_encode(md5($data.$appkey)));
    }

    public function qrcode(Request $request)
    {
        $miniProgram = \EasyWeChat::miniProgram();
        $response = $miniProgram->app_code->get($request->input('path'));
        $img = base64_encode($response);
        return $img;
    }

    public function sendTemplate()
    {
        $miniProgram = \EasyWeChat::miniProgram();
        $data = [
            'template_id' => 'KDC2c5-w-O2ECbvtBYn1ATDF_-IfqrnDVP3PS4IJ0eI', // 所需下发的订阅模板id
            'touser' => 'oEOy55VZkvQ85umeRgPLmwpYXLxA',     // 接收者（用户）的 openid
            'page' => 'page/index/index',       // 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
            'miniprogram_state' => 'trial',
            'data' => [         // 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
                'character_string1' => [
                    'value' => '12345678',
                ],
                'phrase3' => [
                    'value' => '有订单',
                ],
                'time4' => [
                    'value' => now(),
                ],
            ],
        ];

        $app = $miniProgram->subscribe_message->send($data);

        return $app;
    }
}
