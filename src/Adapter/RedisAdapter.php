<?php declare(strict_types=1);

namespace Costalong\Swoft\Cache\Adapter;

use Costalong\Swoft\Cache\Cache;
use Costalong\Swoft\Cache\Concern\AbstractAdapter;
use Costalong\Swoft\Cache\Handle\SetKeyListener\SetKeyLogs;
use Swoft;
use Swoft\Redis\Pool;
use function class_exists;
use function count;

/**
 * Class RedisAdapter
 *
 * @since 2.0.7
 */
class RedisAdapter extends AbstractAdapter
{
    /**
     * @var Pool
     */
    private $redis;

    /**
     * The prefix for session key
     *
     * @var string
     */
    protected $prefix = 'swoft_cache:';

    /**
     * @var string
     */
    protected $setKey= SetKeyLogs::class;

    /**
     * @var bool
     */
    protected $openListener = false;

    /**
     * @return bool
     */
    public static function isSupported(): bool
    {
        return class_exists(Pool::class);
    }

    /**
     * @param Pool $redis
     */
    public function setRedis(Pool $redis): void
    {
        $this->redis = $redis;
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function has($key): bool
    {
        return (bool)$this->redis->exists($key);
    }

    /**
     * @param $key
     * @param null $ttl
     */
    public function expire($key,$ttl=null):bool
    {
        $cacheKey = $this->getCacheKey($key);
        $ttl   = $this->formatTTL($ttl);
        return $this->redis->expire($cacheKey,$ttl);
    }


    /**
     * @param string       $key
     * @param mixed        $value
     * @param null|integer $ttl
     *
     * @return bool
     */
    public function set($key, $value, $ttl = null): bool
    {
        $cacheKey = $this->getCacheKey($key);
        $ttl   = $this->formatTTL($ttl);
        $value = $this->getSerializer()->serialize($value);

        // 开启监听
        if ($this->openListener){
            Swoft::trigger(Cache::SET_KEY_EVENT, 'target', $key, $value,$this->redis->getRedisDb(),$this->setKey);
        }

        // 写入 redis
        if ($ttl > 0){
            return $this->redis->set($cacheKey, $value, $ttl);
        }
        return $this->redis->set($cacheKey, $value);
    }

    /**
     * @param string $key
     *
     * @return bool
     */
    public function delete($key): bool
    {
        $cacheKey = $this->getCacheKey($key);
        return $this->redis->del($cacheKey) === 1;
    }

    /**
     * @param iterable|array $values
     * @param null|integer   $ttl
     *
     * @return bool
     */
    public function setMultiple($values, $ttl = null): bool
    {
        $ttl = $this->formatTTL($ttl);

        return $this->redis->mset($values, $ttl);
    }

    /**
     * @param array $keys
     *
     * @return bool
     */
    public function deleteMultiple($keys): bool
    {
        $keys = $this->checkKeys($keys);

        return $this->redis->del(...$keys) === count($keys);
    }

    /**
     * {@inheritDoc}
     */
    public function get($key, $default = null)
    {
        $this->checkKey($key);
        $cacheKey = $this->getCacheKey($key);

        $value = $this->redis->get($cacheKey);
        if ($value === false) {
            return $default;
        }

        return $this->getSerializer()->unserialize((string)$value);
    }

    /**
     * Wipes clean the entire cache's keys.
     *
     * @return bool True on success and false on failure.
     */
    public function clear(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function getMultiple($keys, $default = null)
    {
        $rows = [];
        $list = $this->redis->mget((array)$keys);

        foreach ($list as $item) {
            $rows[] = $this->getSerializer()->unserialize($item);
        }

        return $rows;
    }
}
