<?php

Route::post('payment/wechat/notify', 'ReturnsController@wechatNotify')
    ->name('payment.wechat.notify');

Route::post('payment/alipay/notify', 'ReturnsController@alipayNotify')
    ->name('payment.alipay.notify');

Route::get('payment/alipay/return', 'ReturnsController@alipayReturn')
    ->name('payment.alipay.return');

Route::post('payment/wechat/refund_notify', 'ReturnsController@wechatRefundNotify')
    ->name('payment.wechat.refund_notify');

Route::prefix("contact")->namespace("Contact")->group(function ($route) {
    //服务器验证
    $route->get("validate/token", "HostValidateTokenController@checkWXGetToken");
});
