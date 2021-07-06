<?php
/**
 * Class CacheTest
 * author:costalong
 * Email:longqiuhong@163.com
 */


namespace Costalong\Swoft\CacheTest\Unit;

use Costalong\Swoft\Cache\Adapter\ArrayAdapter;
use Costalong\Swoft\Cache\Adapter\RedisAdapter;
use Costalong\Swoft\Cache\Cache;
use Costalong\Swoft\Cache\CacheManager;
use Costalong\Swoft\CacheTest\Testing\UserService;
use PHPUnit\Framework\TestCase;
use Swoft\Bean\BeanFactory;


/**
 * Class CacheTest
 * @package Costalong\Swoft\Kafka\Unit
 */
class CacheTest extends TestCase
{
    /**
     */
    public function testCeche()
    {
//        var_dump(Cache::clear());
////        Cache::set("test",111,100);
//        var_dump("获取：".Cache::get("test"));
//        var_dump( "删除:".Cache::delete("test") == true);
//        var_dump( Cache::get("test"));
//
//        if (Cache::lock('foo', 1000)->get()) {
//            // 获取锁定10秒...
//            Cache::lock('foo')->release();
//        }

        Cache::lock('foo', 10)->block(5, function () {
            // 等待最多5秒后获取锁定...
            return false;
        });

    }

    public function testRemember()
    {
        $value = Cache::remember('users', 30, function () {
           return 111;
        });
        var_dump($value);


        //数据永久存储  需要调用delete清除
        Cache::forever('key', 'value');
    }

    public function testUserService()
    {
        $userService = new UserService();
        $userService->cache2(111);
    }
}
