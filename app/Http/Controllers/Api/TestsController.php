<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use Wythe\Logistics\Logistics;

class TestsController extends Controller
{
    public function show()
    {
        $logistics = new Logistics();
        $logistics->query('12313131231', 'kuaidibird');
        return $logistics;
    }
}
