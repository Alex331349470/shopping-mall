<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use Wythe\Logistics\Logistics;

class TestsController extends Controller
{
    public function show(Logistics $logistics)
    {
        dd($logistics->query('12312312412','kuaidibird'));


    }
}
