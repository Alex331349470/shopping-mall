<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BonusResource;
use Illuminate\Http\Request;

class BonusesController extends Controller
{
    public function index(Request $request)
    {
        $bonuses = $request->user()->bonuses;

        dd($bonuses);

        return new BonusResource($bonuses);
    }
}
