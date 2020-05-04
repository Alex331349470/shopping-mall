<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BonusResource;
use Illuminate\Http\Request;

class BonusesController extends Controller
{
    public function index(Request $request)
    {
        $bonuses = $request->user()->bonuses()->with('user')->paginate(6);
        BonusResource::wrap('data');
        return new BonusResource($bonuses);
    }

    public function bonusTotal(Request $request)
    {
        $total = \DB::table('bonuses')->where('user_id',$request->user()->id)->sum('bonus');

        return response([
            'total' => $total
        ])->setStatusCode(200);
    }
}
