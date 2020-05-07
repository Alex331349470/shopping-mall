<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;

class TestsController extends Controller
{
    public function show()
    {
        $status = Order::$shipStatusMap['pending'];
        dd(Order::SHIP_STATUS_NOTICE);
    }
}
