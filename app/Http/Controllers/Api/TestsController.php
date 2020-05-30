<?php

namespace App\Http\Controllers\Api;

use Finecho\Logistics\Logistics;
use GuzzleHttp\Client;
use Illuminate\Http\Request;


class TestsController extends Controller
{
    public function show(Request $request)
    {
	if ($request->company == "YJYP") {
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

            return $data;
        }
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
                    'value' => now()->toDateTimeString(),
                ],
            ],
        ];

        $app = $miniProgram->subscribe_message->send($data);

        return $app;
    }

    public function checkAddress(Request $request)
    {
        $addresses = ['新添大道北段','航天路','云锦路','马东路','红田路','龙广路','北龙路','洪边路','北衙路','农科路','松溪路','育新路','观溪镇','环溪路','狮岩路','新竹路','篷山路','公馆路','高新路','新庄路','水东路','石厂路','新创路','钟坡东路','温石路','温泉路','梅兰山路','富康路','沿山路','钟坡西路','新泉路','五福路','臣功街','燕山大道','巴寨路','温泉大道','顺海中路','四光路','大坡路','新光路','滨滨南路','滨溪北路','观溪北路','创业路','花里大道','友邻路','松溪路','威门路','高新路口','新庄幸福小区','乐湾国际','保利公园','城市魔方','恒大雅苑','未来方舟g10组团','科开一号苑','水锦花都','泉城首府','保利香槟花园','保利春天大道','新天卫城','地矿新庄','幸福里','涧桥泊林','泉天下','臣功新天地','城市山水公园','仁恒别墅','天骄豪园','燕山雅筑','振华港湾','振华港湾d栋','尚善御景','恒大都会广场','水锦花都3期','中天甜蜜小镇6组团','保利温泉新城4期','三湖美郡','云锦尚城','青果壹品峰景2期','航洋世纪商住楼','蓝波湾','振华锦源','振华生活小区','贵州师范学院公租房','新添太阳城','悦景新城','嘉馨苑','新添汇小区','保利紫薇郡','汤泉house','恒大雅苑','蓝景街区','交通巷一号苑','顺海小区','颐华府','雅旭园','湖语美郡','金穗园栋','梅兰山嘉馨苑','湖语御景','三花社区','顺海林峰苑二期','银泰花园','桂苑小区','劲嘉新天荟','水清木华','保利紫薇郡','新康小区','地矿局105地质队','金锐花园','凤来仪小区一期','凤来仪小区二期','贵御温泉小区','顺新公寓','公园小区','林城之星','天骄豪园','碧水人家','桂苑小区','顺新社区','东部新城','湖雨御景','雅旭园','贵州地矿117地质大队','新云小区','新星园','中天甜蜜小镇','温泉御景外滩一号','翡翠湾','金江苑社区','中天未来方舟F4组团','中天未来方舟E1区','中天未来方舟D15组团','中天未来方舟E3组团','中天未来方舟G1组团','新都花园','温泉曦月湾','叶家庄新村苑', '云锦尚城'];

        foreach ($addresses as $address) {
//           dd(strpos('www.baidu.com','www')!==false);
            if (strstr(strtoupper($request->address),$address)!==false) {
                return '该地址可两小时送达';
            }

        }

    }
}
