<?php
/**
 * Class Cache
 * author:costalong
 * Email:longqiuhong@163.com
 *
 */

namespace Costalong\Swoft\Cache;


use Closure;
use Costalong\Swoft\Cache\Contract\CacheAdapterInterface;
use Costalong\Swoft\Cache\Lock\LockContract;
use Swoft;

/**
 * Class Cache
 * @package Costalong\Swoft\Cache
 *
 * @method static bool has($key)
 * @method static bool set($key, $value, $ttl = null)
 * @method static get($key, $default = null)
 * @method static delete($key)
 * @method static bool clear()
 * @method static array getMultiple($keys, $default = null)
 * @method static bool setMultiple($values, $ttl = null)
 * @method static bool deleteMultiple($keys)
 * @method static CacheAdapterInterface getAdapter()
 * @method static void setAdapter(CacheAdapterInterface $adapter)
 * @method static LockContract lock($key, int $ttl = 0, $value = null)
 * @method static remember($key, $ttl, Closure $callback)
 * @method static rememberForever($key, Closure $callback)
 * @method static bool forever($key, $value)
 * @method static pull($key, $default = null)
 * @method static clearTrigger(string $event, array $args = [], $target = null)
 *
 */
final class Cache
{
    // Cache manager bean name
    public const LOCK    = 'cacheLock';

    // Cache manager bean name
    public const MANAGER = 'cacheManager';
    public const ADAPTER = 'cacheAdapter';
    public const SERIALIZER = 'cacheSerializer';

    public const CLEAR_EVENT = 'cache.event.clear';
    public const SET_KEY_EVENT = 'set.key.event';

    public const ASP_BEFORE = 'before';
    public const ASP_AFTER = 'after';




    /**
     * @return CacheManager
     */
    public static function manager(): CacheManager
    {
        return Swoft::getBean(self::MANAGER);
    }

    /**
     * @param string $method
     * @param array $arguments
     * @return mixed
     */
    public static function __callStatic(string $method, array $arguments)
    {
        $cacheManager = self::manager();
        return $cacheManager->{$method}(...$arguments);
    }
}
