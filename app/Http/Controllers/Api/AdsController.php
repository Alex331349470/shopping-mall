<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AdResource;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdsController extends Controller
{
    public function index()
    {
        //获取广告collection
        $ads = Ad::all()->toArray();

        return new AdResource($ads);
    }
}
