<?php
/**
 * Created by PhpStorm.
 * User: WytheHuang
 * Date: 2019/6/21
 * Time: 23:03.
 */
declare(strict_types=1);

/*
 * This file is part of the uuk020/logistics.
 *
 * (c) WytheHuang<wythe.huangw@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Wythe\Logistics;

/**
 * 配置类.
 */
class Config
{
    private $config = [
        'kuaidibird' => ['app_key' => 'e702814c-64a3-4efc-b85c-b341135d311a', 'app_secret' => 'test1639610', 'vip' => false], // 免费套餐 3000 次
    ];

    /**
     * 获取配置.
     *
     * @param string $key
     *
     * @return array
     */
    public function getConfig(string $key): array
    {
        return $this->config[$key];
    }
}
