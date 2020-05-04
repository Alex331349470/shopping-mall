<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BonusResource;
use Illuminate\Http\Request;

class BonusesController extends Controller
{
    public function index(Request $request)
    {
        $bonuses = $request->user()->bonuses()->with('user')->paginate(6);
        if (empty($bonuses)) {
            abort(403, '用户没有收益');
        }
        return new BonusResource($bonuses);
    }
}
