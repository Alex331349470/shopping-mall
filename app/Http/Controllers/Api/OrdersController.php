<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ApplyRefundRequest;
use App\Http\Requests\Api\OrderReceiveReuqest;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Jobs\CloseOrder;
use App\Models\Coupon;
use App\Models\Good;
use App\Models\GoodSku;
use App\Models\UserAddress;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->with('user', 'items.good.images', 'items.good.category')->orderBy('created_at', 'desc')->get();


        OrderResource::wrap('data');

        return new OrderResource($orders);
    }

    public function replyIndex(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->with('user', 'items.good.images')->orderBy('created_at', 'desc')->get();

        OrderResource::wrap('data');
        return new OrderResource($orders);
    }

    public function show(Order $order)
    {
        $order = $order->with('user', 'items.good.images', 'items.good.category')->whereId($order->id)->first();
        return new OrderResource($order);
    }

    public function store(OrderRequest $request)
    {
        $user = $request->user();

        $good_ids = explode(',', $request->good_ids);

        $order = DB::transaction(function () use ($user, $request, $good_ids) {

            $address = UserAddress::find($request->address_id);
            // 创建一个订单
            $order = new Order([
                'address' => [ // 将地址信息放入订单中
                    'address' => $address->full_address,
                    'zip' => $address->zip,
                    'contact_name' => $address->contact_name,
                    'contact_phone' => $address->contact_phone,
                ],
                'remark' => $request->input('remark'),
                'total_amount' => 0,
            ]);
            // 订单关联到当前用户
            $order->user()->associate($user);
            // 写入数据库
            $order->save();
            $totalAmount = 0;
            $totalWeight = 0.00;
            foreach ($good_ids as $good_id) {
                if (!$good = Good::find($good_id)) {
                    abort(403, '不存在ID为' . $good_id . '的商品');
                }

                if (!$good->on_sale) {
                    abort(403, $good->title . '未上架');
                }

                if ($good->stock === 0) {
                    abort(403, $good->title . '库存为零');
                }

                // 创建一个 OrderItem 并直接与当前订单关联
                $item = $order->items()->make([
                    'amount' => $amount = $user->cartItems()->where('good_id', $good_id)->first()->amount,
                    'price' => $good->price,
                ]);

                $item->good()->associate($good);

                $item->save();
                $totalAmount += $good->price * $amount;
                $totalWeight += $good->weight * $amount;

                if ($good->decreaseStock($amount) <= 0) {
                    abort(403, '该商品库存不足');
                }
            }

//            if ($totalAmount >= 88) {
//                $order->update(['ship_price' => 0]);
//            } else if ($totalAmount < 88 && $totalWeight <= 5) {
//                $order->update(['ship_price' => 6]);
//                $totalAmount += 6;
//            } else if ($totalAmount < 88 && $totalWeight > 5) {
//                $ship_price = $totalWeight + 1;
//                $order->update(['ship_price' => $ship_price]);
//                $totalAmount += $ship_price;
//            }
            $order->update(['ship_price' => 0]);
            if ($request->coupon_id) {
                $coupon = Coupon::query()->where('id', $request->coupon_id)->first();
                $totalAmount -= $coupon->coupon;
                $coupon->order_id = $order->id;
                $coupon->used = true;
                $coupon->save();
            }
            // 更新订单总金额
            $order->update(['total_amount' => $totalAmount]);

            // 将下单的商品从购物车中移除
            $user->cartItems()->whereIn('good_id', $good_ids)->delete();
            $this->dispatch(new CloseOrder($order, config('app.order_ttl')));
            return $order;
        });

        return new OrderResource($order);
    }

    public function search(Request $request)
    {
        $builder = Order::query();
        // 判断是否有提交 search 参数，如果有就赋值给 $search 变量
        // search 参数用来模糊搜索商品
        if ($search = $request->input('search', '')) {
            $like = '%' . $search . '%';
            // 模糊搜索商品标题、商品详情
            $builder->where(function ($query) use ($like) {
                $query->where('no', 'like', $like);
            });

            $orders = $builder->with('user', 'items.good.images', 'items.good.category')->paginate(9);

            return new OrderResource($orders);
        }
    }

    public function received(OrderReceiveReuqest $request)
    {
        $order = Order::query()->where('no', $request->no)->first();

        $order->ship_status = Order::SHIP_STATUS_RECEIVED;
        $order->save();

        return new OrderResource($order);
    }

    public function replied(Request $request)
    {
        $order = Order::query()->where('no', $request->no)->first();
        $order->reply_status = true;
        $order->save();

        return new OrderResource($order);
    }

    public function cancelled(Request $request)
    {
        $order = Order::query()->where('no', $request->no)->first();
        $order->cancel = true;
        $order->save();

        return new OrderResource($order);
    }

    public function notice(Order $order)
    {
        $order->ship_status = Order::SHIP_STATUS_NOTICE;
        $order->save();

        return new OrderResource($order);
    }

    public function wechatMessage(Order $order)
    {
        if ($order->paid_at) {

            return response()->json([
                '1' => '订单已支付'
            ])->setStatusCode(200);
        }

        return response()->json([
            '0' => '订单未支付'
        ])->setStatusCode(200);
    }

    public function applyRefund(Order $order, ApplyRefundRequest $request)
    {
        $user_id = $request->user()->id;
        if ($order->user_id !== $user_id) {
            abort(403, '该订单不是当前用户订单');
        }

        if (!$order->paid_at) {
            abort(403, '该订单未支付，不可退款');
        }

        if ($order->refund_data == Order::REFUND_STATUS_APPLIED) {
            abort(403, '该订单已经申请过退款，请勿重复操作');
        }

        $extra = $order->extra ?: [];
        $extra['refund_reason'] = $request->reason;

        $order->update([
            'refund_status' => Order::REFUND_STATUS_APPLIED,
            'extra' => $extra
        ]);

        return new OrderResource($order);
    }


}
