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
}
