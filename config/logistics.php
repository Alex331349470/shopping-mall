<?php

/*
 * This file is part of the finecho/logistics.
 *
 * (c) finecho <liuhao25@foxmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

return [
    'provider' => 'kdniao',

    'kdniao' => [
         'app_code' => env('LOGISTICS_APP_CODE'), /* AppKey  */
         'customer' => env('LOGISTICS_CUSTOMER'), /* EBusinessID  */
    ],
];
