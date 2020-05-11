<?php

namespace App\Admin\Controllers\wx;

use App\Admin\Extensions\OrderExcelExporter;
use App\Admin\Extensions\OrderRefund;
use App\Http\Requests\Admin\HandleRefundRequest;
use App\Models\Order;
use App\Models\OrderItem;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Request;

class OrderController extends AdminController
{
    use ValidatesRequests;
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品订单';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());
        $type = request()->get("type");
        switch ($type) {
            case 2: // 待发货
                $grid->model()->whereNotNull('paid_at')
                    ->where('ship_status', Order::SHIP_STATUS_PENDING)
                    ->where('refund_status', Order::REFUND_STATUS_PENDING);
                break;
            case 3: // 退款申请
                $grid->model()->where('refund_status', Order::REFUND_STATUS_APPLIED);
                break;
            case 4: // 完成订单
                $grid->model()->where('ship_status', Order::SHIP_STATUS_RECEIVED);
                break;
            case 5: // 提醒发货
                $grid->model()->where('ship_status', Order::SHIP_STATUS_NOTICE);
                break;
            default:
        }

        $grid->header(function ($query) {
            $info = [];

            $info['total_finished'] = Order::getFinishWhere()->count("id");

            $info['total_unship'] = Order::getUnShipWhere()->count("id");

            $info['total_unrefund'] = Order::getUnRefundWhere()->count("id");

            $info['total_all'] = Order::query()->count("id");

            $info['total_notify'] = Order::getNotifyShipWhere()->count("id");

            $doughnut = view('admin.orders.header', compact('info'));
            return new Box('订单状态展示', $doughnut);
        });

        $grid->column('id', __('Id'));
        $grid->column('no', __('订单编号'));
        $grid->column('user.name', __('用户名'));
        $grid->column('address', __('地址'))->display(function ($value) {
            $address = '';
            if (isset($value['address'])) {
                $address .= '地址：' . mb_convert_encoding($value['address'], 'UTF8');
            }
            if (isset($value['zip'])) {
                $address .= ' 邮编：' . $value['zip'];
            }
            if (isset($value['contact_name'])) {
                $address .= ' 联系人：' . mb_convert_encoding($value['contact_name'], 'UTF8');
            }
            if (isset($value['contact_phone'])) {
                $address .= ' 电话：' . mb_convert_encoding($value['contact_phone'], 'UTF8');
            }
            return $address;
        });
        $grid->column('total_amount', __('总价'));
        $grid->column('remark', __('备注'));
        $grid->column('paid_at', __('支付时间'));
        $grid->column('payment_method', __('支付方式'));
        $grid->column('payment_no', __('流水号'));
        $grid->column('refund_status', __('退款退货状态'))->display(function ($value) {
            return isset(Order::$refundStatusMap[$value])?Order::$refundStatusMap[$value]:$value;
        });
        $grid->column('refund_no', __('退款退货单号'));
        $grid->column('closed', __('是否关闭'))->display(function ($value) {
            return $value == 0?'否':'是';
        });
        $grid->column('reply_status', __('是否评价'))->display(function ($value) {
            return $value == 0?'否':'是';
        });
        $grid->column('cancel', __('是否取消'))->display(function ($value) {
            return $value == 0?'否':'是';
        });
        $grid->column('ship_status', __('物流状态'))->display(function ($value) {
            return isset(Order::$shipStatusMap[$value])?Order::$shipStatusMap[$value]:$value;
        });
        $grid->column('ship_data', __('物流信息'))->display(function ($value) {
            $ship_data = '';
            if (isset($order->ship_data['express_company'])) {
                $ship_data .= '物流公司：' . $value['express_company'];
            }
            if (isset($order->ship_data['express_no'])) {
                $ship_data .= ' 订单编号：' . $value['express_no'];
            }
            return $ship_data;
        });
//        $grid->column('extra', __('其他数据'))->display(function ($value) {
//            if ($value->reason) {
//                return "申请退款：" . $value->reason;
//            }
//
//            if ($value->refund_disagree_reason) {
//                return "拒绝退款：" . $value->refund_disagree_reason;
//            }
//        });
        $grid->column('created_at', __('创建时间'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableDelete();
//            $actions->disableView();
//            $actions->add(new ModelList($actions->getKey(), 'order.info.list', '订单详情'));
            if ($actions->row->refund_status == Order::REFUND_STATUS_APPLIED) {
                $extra_json = $actions->row->extra;
                $actions->add(new OrderRefund($actions->getKey(), 'admin.orders.handle_refund', '是否退款', $extra_json->reason??''));
            }
        });
        $grid->filter(function (Grid\Filter $filter) {
            $filter->disableIdFilter();
            $filter->like('no', '编号');
            $filter->like('user.name', '会员名');
        });
        $grid->disableCreateButton();
        $grid->exporter(new OrderExcelExporter());
        return $grid;
    }

    public function infoList($id, Content $content) {
        return $content
            ->title($this->title())
            ->description($this->description['index'] ?? trans('admin.list'))
            ->body($this->InfoGrid($id));
    }

    public function InfoGrid($order_id) {
        $grid = new Grid(new OrderItem());
        $grid->model()->where('order_id', $order_id);

        $grid->column('goods.title', __('商品名称'));
        $grid->column('amount', __('数量'));
        $grid->column('price', __('单价'));
        $grid->column('rating', __('评分'));
        $grid->column('goods.express_price', __('市场价'));
        $grid->column('goods.price', __('售价'));

        $grid->actions(function (Grid\Displayers\Actions $actions) {
            $actions->disableAll();
        });
        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->disableCreateButton();
        $grid->disableFilter();
        return $grid;
    }

    public function show($id, Content $content)
    {
        return $content
            ->header('查看订单')
            // body 方法可以接受 Laravel 的视图作为参数
            ->body(view('admin.orders.show', ['order' => Order::find($id)]));
    }

    public function ship(Order $order, \Illuminate\Http\Request $request)
    {
        // 判断当前订单是否已支付
        if (!$order->paid_at) {
            abort(403,'该订单未付款');
        }
        // 判断当前订单发货状态是否为未发货
        if ($order->ship_status == Order::SHIP_STATUS_DELIVERED) {
            abort(403,'该订单已发货');
        }
        // Laravel 5.5 之后 validate 方法可以返回校验过的值
        $data = $this->validate($request, [
            'express_company' => ['required'],
            'express_no'      => ['required'],
        ], [], [
            'express_company' => '物流公司',
            'express_no'      => '物流单号',
        ]);
        // 将订单发货状态改为已发货，并存入物流信息
        $order->update([
            'ship_status' => Order::SHIP_STATUS_DELIVERED,
            // 我们在 Order 模型的 $casts 属性里指明了 ship_data 是一个数组
            // 因此这里可以直接把数组传过去
            'ship_data'   => $data,
        ]);

        // 返回上一页
        return redirect()->back();
    }
    public function received(Order $order, Request $request)
    {
        // 判断订单的发货状态是否为已发货
        if ($order->ship_status !== Order::SHIP_STATUS_DELIVERED) {
            abort(403,'未发货');
        }

        // 更新发货状态为已收到
        $order->update(['ship_status' => Order::SHIP_STATUS_RECEIVED]);

        // 返回原页面
        return response(null,201);
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Order::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('no', __('No'));
        $show->field('user_id', __('User id'));
        $show->field('address', __('Address'));
        $show->field('total_amount', __('Total amount'));
        $show->field('remark', __('Remark'));
        $show->field('paid_at', __('Paid at'));
        $show->field('payment_method', __('Payment method'));
        $show->field('payment_no', __('Payment no'));
        $show->field('refund_status', __('Refund status'));
        $show->field('refund_no', __('Refund no'));
        $show->field('closed', __('Closed'));
        $show->field('reply_status', __('Reply status'));
        $show->field('cancel', __('Cancel'));
        $show->field('ship_status', __('Ship status'));
        $show->field('ship_data', __('Ship data'));
        $show->field('extra', __('Extra'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order());

        $form->text('no', __('订单编号'))->disable();
        $form->text('user.name', __('用户名'))->disable();
        $form->textarea('address', __('地址'))->disable();
        $form->decimal('total_amount', __('总价'))->disable();
        $form->textarea('remark', __('备注'))->disable();
        $form->datetime('paid_at', __('支付时间'))->disable();
        $form->text('payment_method', __('支付方式'))->disable();
//        $form->text('payment_no', __('流水号'))->disable();
        $form->text('refund_status', __('退款退货状态'))->default('pending');
        $form->text('refund_no', __('退款退货单号'));
        $form->switch('closed', __('是否关闭'));
//        $form->switch('reply_status', __('是否已评价'))->disable();
//        $form->switch('cancel', __('是否取消'))->disable();
        $form->text('ship_status', __('物流状态'))->default('pending');
        $form->textarea('ship_data', __('物流信息'));
        $form->textarea('extra', __('其他数据'));

        $form->disableCreatingCheck();
        $form->disableEditingCheck();
        $form->disableViewCheck();
        return $form;
    }

    public function handleRefund(Order $order, HandleRefundRequest $request)
    {
        // 判断订单状态是否正确
        if ($order->refund_status !== Order::REFUND_STATUS_APPLIED) {
            abort(403,'订单状态不正确');
        }
        // 是否同意退款
        if ($request->input('agree')) {
            // 同意退款的逻辑这里先留空
            // 清空拒绝退款理由
            $extra = $order->extra ?: [];
            unset($extra['refund_disagree_reason']);
            $order->update([
                'extra' => $extra,
            ]);
            // 调用退款逻辑
            $this->_refundOrder($order);
        } else {
            // 将拒绝退款理由放到订单的 extra 字段中
            $extra = $order->extra ?: [];
            $extra['refund_disagree_reason'] = $request->input('reason');
            // 将订单的退款状态改为未退款
            $order->update([
                'refund_status' => Order::REFUND_STATUS_PENDING,
                'extra'         => $extra,
            ]);
        }

        return response()->json(['code' => 200, 'message' => '操作成功']);
    }

    protected function _refundOrder(Order $order)
    {
        switch ($order->payment_method) {
            case 'wechat':
                // 生成退款订单号
                $refundNo = Order::getAvailableRefundNo();
                app('wechat_pay')->refund([
                    'out_trade_no' => $order->no, // 之前的订单流水号
                    'total_fee' => $order->total_amount * 100, //原订单金额，单位分
                    'refund_fee' => $order->total_amount * 100, // 要退款的订单金额，单位分
                    'out_refund_no' => $refundNo, // 退款订单号
                    'type' => 'miniapp',//设置type为微信小程序退款
                    // 微信支付的退款结果并不是实时返回的，而是通过退款回调来通知，因此这里需要配上退款回调接口地址
                    'notify_url' => env('APP_URL').'/payment/wechat/refund_notify',
                ]);
                // 将订单状态改成退款中
                $order->update([
                    'refund_no' => $refundNo,
                    'refund_status' => Order::REFUND_STATUS_PROCESSING,
                ]);
                break;

            default:
                abort(403,'未知订单支付方式：'.$order->payment_method);
                break;
        }
    }
}
