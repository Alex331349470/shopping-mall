<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BonusResource;
use Illuminate\Http\Request;

class BonusesController extends Controller
{
    public function index(Request $request)
    {
        if (!($bonuses = $request->user()->bonuses()->with('user')->paginate(6))) {
            abort(403, '用户没有收益');
        }
        return new BonusResource($bonuses);
    }
}
