<?php
namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;

class HostValidateTokenController extends Controller{

    public function checkWXGetToken() {
        $signature = request()->get("signature");
        $timestamp = request()->get("timestamp");
        $nonce = request()->get("nonce");

        //客服消息验证token
        $token = "qweasdzxcrtyfghvbn";
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if ($tmpStr == $signature ) {
            return true;
        } else {
            return false;
        }
    }



}
