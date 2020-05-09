<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use Wythe\Logistics\Logistics;

class TestsController extends Controller
{
    public function show(Logistics $logistics)
    {
        $message = $logistics->query('1231234123','','ZTO');

        dd($message);

    }
}
