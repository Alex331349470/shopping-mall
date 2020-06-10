<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BonusResource;
use Illuminate\Http\Request;

class BonusesController extends Controller
{
    //获取当前用户bonuses信息
    public function index(Request $request)
    {
        $bonuses = $request->user()->bonuses()->with('user')->paginate(6);
        BonusResource::wrap('data');
        return new BonusResource($bonuses);
    }

    //获取用户当前bonuses总和
    public function bonusTotal(Request $request)
    {
        $total = \DB::table('bonuses')->where('user_id',$request->user()->id)->sum('bonus');

        if (!$total)  {
            return response([
                'total' => 0,
            ])->setStatusCode(200);
        }

        return response([
            'total' => $total
        ])->setStatusCode(200);
    }
}
