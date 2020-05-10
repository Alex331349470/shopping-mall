<?php
namespace App\Admin\Extensions;

use App\Models\Order;
use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExcelExporter extends ExcelExporter implements WithMapping {
    protected $fileName = '订单管理.xlsx';

    protected $headings = [
        'id' => 'ID',
        'no' => '订单编号',
        'name' => '用户名',
        'address' => '地址',
        'total_amount' => '总价',
        'remark' => '备注',
        'paid_at' => '支付时间',
        'payment_method' => '支付方式',
        'payment_no' => '流水号',
        'refund_status' => '退款退货状态',
        'refund_no' => '退款退货单号',
        'closed' => '是否关闭',
        'reply_status' => '是否评价',
        'cancel' => '是否取消',
        'ship_status' => '物流状态',
        'ship_data' => '物流信息',
        'extra' => '其他数据',
        'created_at' => '创建时间',
    ];


    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($order): array
    {
        $ship_status = (Order::$shipStatusMap[$order->ship_status])??"";
        $refund_status = (Order::$refundStatusMap[$order->refund_status])??"";
        $ship_data = '';
        if (isset($order->ship_data['express_company'])) {
            $ship_data .= '物流公司：' . $order->ship_data['express_company'];
        }
        if (isset($order->ship_data['express_no'])) {
            $ship_data .= ' 订单编号：' . $order->ship_data['express_no'];
        }

        $address = '';
        if (isset($order->address['address'])) {
            $address .= '地址：' . mb_convert_encoding($order->address['address'], 'UTF8');
        }
        if (isset($order->address['zip'])) {
            $address .= ' 邮编：' . $order->address['zip'];
        }
        if (isset($order->address['contact_name'])) {
            $address .= ' 联系人：' . mb_convert_encoding($order->address['contact_name'], 'UTF8');
        }
        if (isset($order->address['contact_phone'])) {
            $address .= ' 电话：' . mb_convert_encoding($order->address['contact_phone'], 'UTF8');
        }

        return [
            $order->id,
            $order->no,
            $order->name,
            $address,
            $order->total_amount,
            $order->remark,
            $order->paid_at,
            $order->payment_method,
            $order->payment_no,
            $refund_status,
            $order->refund_no,
            $order->closed == 0?'否':'是',
            $order->reply_status == 0?'否':'是',
            $order->cancel == 0?'否':'是',
            $ship_status,
            $ship_data,
            $order->extra,
            $order->created_at
        ];
    }
}
