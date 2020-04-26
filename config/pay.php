<?php

return [
    'wechat' => [
        'app_id'      => 'wxc0bae71f6caa7acf',
        'mch_id'      => '1588341211',
        'key'         => 'zuSAxunIBlFywbPDUkC8XRh32Lbtn1eJ',
        'cert_client' => resource_path('wechat_pay/apiclient_cert.pem'),
        'cert_key'    => resource_path('wechat_pay/apiclient_key.pem'),
        'log'         => [
            'file' => storage_path('logs/wechat_pay.log'),
        ],
    ],
];