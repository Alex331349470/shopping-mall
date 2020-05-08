<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function service()
    {
       $miniProgram = \EasyWeChat::miniProgram();
       $service = $miniProgram->customer_service;

       return $service;
    }
}
