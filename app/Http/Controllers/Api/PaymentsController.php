<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function payByWechat(Order $order, Request $request)
    {
        if ($order->paid_at || $order->closed) {
            abort(403, '订单状态不正确');
        }

        return app('wechat_pay')->miniapp([
            'out_trade_no' => $order->no,
            'total_fee' => $order->total_amount * 100,
            'body' => '支付订单:' . $order->no,
        ]);
    }

    public function payByAlipay(Order $order, Request $request)
    {
        if ($order->paid_at || $order->closed) {
            abort(403, '订单状态不正确');
        }

        return app('alipay')->web([
            'out_trade_no' => $order->no,
            'total_amount' => $order->total_amount,
            'subject' => '支付订单：' . $order->no,
        ]);
    }
}
