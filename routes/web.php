<?php

Route::post('payment/wechat/notify', 'ReturnsController@wechatNotify')
    ->name('payment.wechat.notify');

Route::post('payment/alipay/notify', 'ReturnsController@alipayNotify')
    ->name('payment.alipay.notify');

Route::get('payment/alipay/return', 'ReturnsController@alipayReturn')
    ->name('payment.alipay.return');