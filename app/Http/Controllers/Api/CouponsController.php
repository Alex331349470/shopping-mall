<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CouponRequest;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function store(CouponRequest $request)
    {
        if (Coupon::query()->whereUserId($request->user_id)) {
            abort(403,'用户已经有优惠券');
        }

        $coupon = Coupon::create([
            'user_id' => $request->user_id,
            'coupon' => rand(1,3),
        ]);

        return response(null,201);
    }
}
