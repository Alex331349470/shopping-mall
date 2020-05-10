<?php
namespace App\Admin\Extensions;

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
        return [
            $order->id,
            $order->no,
            $order->name,
            $order->address,
            $order->total_amount,
            $order->remark,
            $order->paid_at,
            $order->payment_method,
            $order->payment_no,
            $order->refund_status,
            $order->refund_no,
            $order->closed,
            $order->reply_status,
            $order->cancel,
            $order->ship_status,
            $order->ship_data,
            $order->extra,
            $order->created_at
        ];
    }
}
