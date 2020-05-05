<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\CouponRequest;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponsController extends Controller
{
    public function store(CouponRequest $request)
    {
        if (Coupon::query()->whereUserId($request->user_id)->get()) {
            abort(403,'用户已经有优惠券');
        }

        $coupon = Coupon::create([
            'user_id' => $request->user_id,
            'coupon' => rand(1,3),
        ]);

        return response(null,201);
    }

    public function index(Request $request)
    {
        $coupon = Coupon::query()->whereUserId($request->user()->id)->first();

        return new CouponResource($coupon);
    }
}
