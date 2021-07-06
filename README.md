# Swoft-cache

Swoft-cache component for swoft framework

## Install

- install by composer

```bash
composer require root/swoft-cache
```

- update bean.php file

```bash
 Cache::MANAGER    => [
        'class'   => CacheManager::class,
        'adapter' => bean(Cache::ADAPTER),
        'lockAdapter' => Cache::LOCK
    ],
    Cache::ADAPTER    => [
        'class'        => RedisAdapter::class,
        'serializer'   => bean(Cache::SERIALIZER),
        'redis'        => bean('redis.pool'),
        "openListener" => true   // is open listener function  eg: false  setKey config invalid
        'setKey'       => \Costalong\Swoft\Cache\Handle\SetKeyListener\SetKeyLogs::class
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
        'host'     => '127.0.0.1',
        'port'     => 6379,
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
```

- use example
```php

  Cache::set("test",111,100);
  $data = Cache::get("test");



 if (Cache::lock('foo', 1000)->get()) {
  // 获取锁定10秒...
  Cache::lock('foo')->release();
}

 Cache::lock('foo', 10)->block(5, function () {
            // 等待最多5秒后获取锁定...
            return false;
});

 $value = Cache::remember('users', 30, function () {
      return 111;
 });

 //数据永久存储  需要调用delete清除
Cache::forever('key', 'value');

```

## LICENSE

The Component is open-sourced software licensed under the [Apache license](LICENSE).
