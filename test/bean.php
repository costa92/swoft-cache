<?php declare(strict_types=1);
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://swoft.org/docs
 * @contact  group@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */


use Costalong\Swoft\Cache\Adapter\RedisAdapter;
use Costalong\Swoft\Cache\Cache;
use Costalong\Swoft\Cache\CacheManager;
use Costalong\Swoft\Cache\Lock\RedisLock;
use Swoft\Serialize\PhpSerializer;

return [
    'config' => [
        'path' => __DIR__ . '/config',
    ],
    Cache::MANAGER    => [
        'class'   => CacheManager::class,
        'adapter' => bean(Cache::ADAPTER),
        'lockAdapter' => Cache::LOCK
    ],
    Cache::ADAPTER    => [
        'class'      => RedisAdapter::class,
        'serializer' => bean(Cache::SERIALIZER),
        'redis' => bean('redis.pool'),
    ],
    //cache原子锁配置
    Cache::LOCK => [
        'class' => RedisLock::class,
        'redis' => bean('redis.pool'),
        'prefix' => 'lock:'
    ],

    Cache::SERIALIZER => [
        'class' => PhpSerializer::class
    ],


    'redis'              => [
        'class'    => \Swoft\Redis\RedisDb::class,
        'host'     => '192.168.11.143',
        "password" => "DG-MALL.com",
        'port'     => 16379,
        'database' => 1,
        'option'   => [
            'prefix' => 'swoft:',
        ]
    ],
    'redis.pool' => [
        'class'       => Swoft\Redis\Pool::class,
        'redisDb'     => bean('redis'),
        'minActive'   => 10,
        'maxActive'   => 20,
        'maxWait'     => 0,
        'maxWaitTime' => 0,
        'maxIdleTime' => 60,
    ]
];
