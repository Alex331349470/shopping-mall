<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Finecho\Logistics\Logistics;
use GuzzleHttp\Client;
use Illuminate\Http\Request;


class TestsController extends Controller
{
    public function show(Request $request)
    {
        if ($request->company == "YJYP") {
            $order = Order::query()->where('ship_data->express_no',$request->code)->first();
            if ($order->self_post) {
                $data = [
                    "LogisticCode" => $request->code,
                    "ShipperCode" => $request->company,
                    "Traces" => [
                        ["AcceptStation" => "商品已发货", "AcceptTime" => ""],
                        ["AcceptStation" => "商品配送中", "AcceptTime" => ""],
                        ["AcceptStation" => "配送人员电话：18212025642", "AcceptTime" => ""],
                        ["AcceptStation" => "已收货", "AcceptTime" => ""],
                    ],
                    "State" => "2",
                    "EBusinessID" => "12345678",
                    "Success" => true,
                ];
            } else {
                $data = [
                    "LogisticCode" => $request->code,
                    "ShipperCode" => $request->company,
                    "Traces" => [
                        ["AcceptStation" => "商品已发货", "AcceptTime" => ""],
                        ["AcceptStation" => "商品配送中", "AcceptTime" => ""],
                        ["AcceptStation" => "配送人员电话：18212025642", "AcceptTime" => ""],
                    ],
                    "State" => "2",
                    "EBusinessID" => "12345678",
                    "Success" => true,
                ];
            }

            return $data;
        }
        $logisticResult = $this->getOrderTracesByJson($request->company, $request->code);

        return $logisticResult;

    }

    /**
     * Json方式 查询订单物流轨迹
     */
    protected function getOrderTracesByJson($company, $code)
    {
        $requestData = "{'OrderCode':'','ShipperCode':'$company','LogisticCode':'$code'}";

        $datas = array(
            'EBusinessID' => env('LOGISTICS_CUSTOMER'),
            'RequestType' => '1002',
            'RequestData' => urlencode($requestData),
            'DataType' => '2',
        );
        $datas['DataSign'] = $this->encrypt($requestData, env('LOGISTICS_APP_CODE'));
        $result = $this->sendPost(env('LOGISTICS_URL'), $datas);

        //根据公司业务处理返回的信息......

        return $result;
    }

    /**
     *  post提交数据
     * @param string $url 请求Url
     * @param array $datas 提交的数据
     * @return url响应返回的html
     */
    protected function sendPost($url, $datas)
    {
        $temps = array();
        foreach ($datas as $key => $value) {
            $temps[] = sprintf('%s=%s', $key, $value);
        }
        $post_data = implode('&', $temps);
        $url_info = parse_url($url);
        if (empty($url_info['port'])) {
            $url_info['port'] = 80;
        }
        $httpheader = "POST " . $url_info['path'] . " HTTP/1.0\r\n";
        $httpheader .= "Host:" . $url_info['host'] . "\r\n";
        $httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
        $httpheader .= "Content-Length:" . strlen($post_data) . "\r\n";
        $httpheader .= "Connection:close\r\n\r\n";
        $httpheader .= $post_data;
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
            $gets .= fread($fd, 128);
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
    protected function encrypt($data, $appkey)
    {
        return urlencode(base64_encode(md5($data . $appkey)));
    }

    public function qrcode(Request $request)
    {
        $miniProgram = \EasyWeChat::miniProgram();
        $response = $miniProgram->app_code->get($request->input('path'));
        $img = base64_encode($response);
        return $img;
    }

}
