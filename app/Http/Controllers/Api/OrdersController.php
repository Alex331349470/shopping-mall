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

        if ($request->sku_ids) {
            $sku_ids = explode(',',$request->sku_ids);
            $order = DB::transaction(function () use ($user, $request, $sku_ids) {
                $address = UserAddress::find($request->address_id);

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
                $arrive_addresses = ['新添大道北段', '航天路', '云锦路', '马东路', '红田路', '龙广路', '北龙路', '洪边路', '北衙路', '农科路', '松溪路', '育新路', '观溪镇', '环溪路', '狮岩路', '新竹路', '篷山路', '公馆路', '高新路', '新庄路', '水东路', '石厂路', '新创路', '钟坡东路', '温石路', '温泉路', '梅兰山路', '富康路', '沿山路', '钟坡西路', '新泉路', '五福路', '臣功街', '燕山大道', '巴寨路', '温泉大道', '顺海中路', '四光路', '大坡路', '新光路', '滨滨南路', '滨溪北路', '观溪北路', '创业路', '花里大道', '友邻路', '松溪路', '威门路', '高新路口', '新庄幸福小区', '乐湾国际', '保利公园', '城市魔方', '恒大雅苑', '未来方舟g10组团', '科开一号苑', '水锦花都', '泉城首府', '保利香槟花园', '保利春天大道', '新天卫城', '地矿新庄', '幸福里', '涧桥泊林', '泉天下', '臣功新天地', '城市山水公园', '仁恒别墅', '天骄豪园', '燕山雅筑', '振华港湾', '振华港湾d栋', '尚善御景', '恒大都会广场', '水锦花都3期', '中天甜蜜小镇6组团', '保利温泉新城4期', '三湖美郡', '云锦尚城', '青果壹品峰景2期', '航洋世纪商住楼', '蓝波湾', '振华锦源', '振华生活小区', '贵州师范学院公租房', '新添太阳城', '悦景新城', '嘉馨苑', '新添汇小区', '保利紫薇郡', '汤泉house', '恒大雅苑', '蓝景街区', '交通巷一号苑', '顺海小区', '颐华府', '雅旭园', '湖语美郡', '金穗园栋', '梅兰山嘉馨苑', '湖语御景', '三花社区', '顺海林峰苑二期', '银泰花园', '桂苑小区', '劲嘉新天荟', '水清木华', '保利紫薇郡', '新康小区', '地矿局105地质队', '金锐花园', '凤来仪小区一期', '凤来仪小区二期', '贵御温泉小区', '顺新公寓', '公园小区', '林城之星', '天骄豪园', '碧水人家', '桂苑小区', '顺新社区', '东部新城', '湖雨御景', '雅旭园', '贵州地矿117地质大队', '新云小区', '新星园', '中天甜蜜小镇', '温泉御景外滩一号', '翡翠湾', '金江苑社区', '中天未来方舟F4组团', '中天未来方舟E1区', '中天未来方舟D15组团', '中天未来方舟E3组团', '中天未来方舟G1组团', '新都花园', '温泉曦月湾', '叶家庄新村苑', '云锦尚城'];
                // 订单关联到当前用户
                $order->user()->associate($user);
                $order->fast_arrive = false;
                foreach ($arrive_addresses as $arrive_address) {
                    if (strpos(strtoupper($address->full_address), $arrive_address)) {
                        $order->fast_arrive = true;
                    }
                }
                // 写入数据库
                $order->save();
                $totalAmount = 0;
                $totalWeight = 0.00;

                foreach ($sku_ids as $sku_id) {
                    if (!$sku = GoodSku::find($sku_id)) {
                        abort(403, '不存在ID为' . $sku_id . '的商品');
                    }

                    if (!$sku->good->on_sale) {
                        abort(403, $sku->good->title . '未上架');
                    }

                    if ($sku->stock === 0) {
                        abort(403, $sku->good->title . '库存为零');
                    }

                    // 创建一个 OrderItem 并直接与当前订单关联
                    $item = $order->items()->make([
                        'amount' => $amount = $user->cartItems()->where('sku_id', $sku_id)->first()->amount,
                        'price' => $sku->price,
                    ]);

                    $item->good()->associate($sku->good);
                    $item->sku()->associcate($sku);
                    $item->save();
                    $totalAmount += $sku->price * $amount;
                    $totalWeight += $sku->good->weight * $amount;

                    if ($sku->decreaseStock($amount) <= 0) {
                        abort(403, '该商品库存不足');
                    }
                }

                if ($totalAmount >= 88) {
                    $order->update(['ship_price' => 0]);
                } else if ($totalAmount < 88 && $totalWeight <= 5) {
                    $order->update(['ship_price' => 6]);
                    $totalAmount += 6;
                } else if ($totalAmount < 88 && $totalWeight > 5) {
                    $ship_price = $totalWeight + 1;
                    $order->update(['ship_price' => $ship_price]);
                    $totalAmount += $ship_price;
                }

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
                $user->cartItems()->whereIn('sku_id', $sku_ids)->delete();
                $this->dispatch(new CloseOrder($order, config('app.order_ttl')));
                return $order;
            });

            return new OrderResource($order);
        }

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
            $arrive_addresses = ['新添大道北段', '航天路', '云锦路', '马东路', '红田路', '龙广路', '北龙路', '洪边路', '北衙路', '农科路', '松溪路', '育新路', '观溪镇', '环溪路', '狮岩路', '新竹路', '篷山路', '公馆路', '高新路', '新庄路', '水东路', '石厂路', '新创路', '钟坡东路', '温石路', '温泉路', '梅兰山路', '富康路', '沿山路', '钟坡西路', '新泉路', '五福路', '臣功街', '燕山大道', '巴寨路', '温泉大道', '顺海中路', '四光路', '大坡路', '新光路', '滨滨南路', '滨溪北路', '观溪北路', '创业路', '花里大道', '友邻路', '松溪路', '威门路', '高新路口', '新庄幸福小区', '乐湾国际', '保利公园', '城市魔方', '恒大雅苑', '未来方舟g10组团', '科开一号苑', '水锦花都', '泉城首府', '保利香槟花园', '保利春天大道', '新天卫城', '地矿新庄', '幸福里', '涧桥泊林', '泉天下', '臣功新天地', '城市山水公园', '仁恒别墅', '天骄豪园', '燕山雅筑', '振华港湾', '振华港湾d栋', '尚善御景', '恒大都会广场', '水锦花都3期', '中天甜蜜小镇6组团', '保利温泉新城4期', '三湖美郡', '云锦尚城', '青果壹品峰景2期', '航洋世纪商住楼', '蓝波湾', '振华锦源', '振华生活小区', '贵州师范学院公租房', '新添太阳城', '悦景新城', '嘉馨苑', '新添汇小区', '保利紫薇郡', '汤泉house', '恒大雅苑', '蓝景街区', '交通巷一号苑', '顺海小区', '颐华府', '雅旭园', '湖语美郡', '金穗园栋', '梅兰山嘉馨苑', '湖语御景', '三花社区', '顺海林峰苑二期', '银泰花园', '桂苑小区', '劲嘉新天荟', '水清木华', '保利紫薇郡', '新康小区', '地矿局105地质队', '金锐花园', '凤来仪小区一期', '凤来仪小区二期', '贵御温泉小区', '顺新公寓', '公园小区', '林城之星', '天骄豪园', '碧水人家', '桂苑小区', '顺新社区', '东部新城', '湖雨御景', '雅旭园', '贵州地矿117地质大队', '新云小区', '新星园', '中天甜蜜小镇', '温泉御景外滩一号', '翡翠湾', '金江苑社区', '中天未来方舟F4组团', '中天未来方舟E1区', '中天未来方舟D15组团', '中天未来方舟E3组团', '中天未来方舟G1组团', '新都花园', '温泉曦月湾', '叶家庄新村苑', '云锦尚城'];
            // 订单关联到当前用户
            $order->user()->associate($user);
            $order->fast_arrive = false;
            foreach ($arrive_addresses as $arrive_address) {
                if (strpos(strtoupper($address->full_address), $arrive_address)) {
                    $order->fast_arrive = true;
                }
            }
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

            if ($totalAmount >= 88) {
                $order->update(['ship_price' => 0]);
            } else if ($totalAmount < 88 && $totalWeight <= 5) {
                $order->update(['ship_price' => 6]);
                $totalAmount += 6;
            } else if ($totalAmount < 88 && $totalWeight > 5) {
                $ship_price = $totalWeight + 1;
                $order->update(['ship_price' => $ship_price]);
                $totalAmount += $ship_price;
            }
//            $order->update(['ship_price' => 0]);
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
